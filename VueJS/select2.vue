<!--
import Select2Component from './components/select2.vue';
Vue.component('select2', Select2Component);

<select2
    v-model="evaluation.teacher_id"
    id="teacher_id"
    placeholder="Select instructor"
    :items="teachers"
    value-key="id"
    display-key="login_id"
>
    <template v-slot="data">
        <option v-for="teacher in data.items" :value="teacher.id">@{{ getFullNameTeacher(teacher) }}</option>
    </template>
</select2>
-->

<template>
    <select :id="elementId" :disabled="disabled" class="form-control">
        <option v-if="placeholder"></option>
        <slot :items="dataItems">
            <option v-for="(item, index) in dataItems" :value="getValueByKey(item, valueKey)" :key="index">{{ getValueByKey(item, displayKey) }}</option>
        </slot>
    </select>
</template>

<script>
    export default {
        props: {
            value: {
                required: true,
                default: undefined,
            },
            items: {
                type: Array,
                required: true,
                default: [],
            },
            placeholder: {
                default: undefined,
                type: String,
            },
            displayKey: {
                type: String,
            },
            valueKey: {
                type: String,
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            id: {
                type: String,
            },
        },
        data() {
            return {
                elementId: null,
                selectedValue: undefined,
                dataItems: [],
            }
        },
        created() {
            this.elementId = this.id || this.makeId(6);
        },
        mounted() {
            this.createSelect2();
        },
        watch: {
            items: {
                deep: true,
                handler(value) {
                    this.dataItems = [];
                    this.$nextTick(() => {
                        this.dataItems = _.clone(value);
                        this.setSelectOption();
                    });
                }
            },
            value: {
                deep: true,
                handler(value) {
                    this.selectedValue = value;
                    this.setSelectOption();
                }
            },
        },
        methods: {
            createSelect2() {
                $(`#${this.elementId}`).select2({
                    theme: 'bootstrap',
                    allowClear: true,
                    placeholder: this.placeholder,
                }).on('change', e => {
                    const index = $(e.target).children(`option[value="${e.target.value}"]`).index() - (this.placeholder ? 1 : 0);
                    this.selectedValue = this.items[index] ? this.getValueByKey(this.items[index], this.valueKey) : undefined;
                    this.emitChange();
                });
            },
            makeId(length) {
                var result = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for (var i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
            },
            getValueByKey(item, key) {
                if (!key) {
                    return item;
                }

                let value = undefined;
                for (const k of key.split('.')) {
                    value = item[k];
                }

                return value;
            },
            emitChange() {
                this.$emit('input', this.selectedValue);
                this.$emit('change');
            },
            setSelectOption() {
                this.$nextTick(() => {
                    if (this.selectedValue === undefined || this.selectedValue === null || this.selectedValue === '') {
                        this.$nextTick(() => {
                            $(`#${this.elementId}`).val('').trigger('change.select2');
                        });
                    } else {
                        const index = this.items.map(item => this.getValueByKey(item, this.valueKey)).findIndex(item => item === this.selectedValue);
                        if (!this.items[index]) return;
                        const select2Value = String(this.getValueByKey(this.items[index], this.valueKey));
                        this.$nextTick(() => {
                            $(`#${this.elementId}`).val(select2Value).trigger('change.select2');
                        });
                    }
                });
            },
        },
    }

</script>

<style>
    .select2-container.select2-container--bootstrap {
        width: auto !important;
    }

</style>
