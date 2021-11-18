<template>
</template>

<script>
export default {
    name: "index",
    data() {
        return {
            formData: {
                name: '',
                type: 1,
                date: '',
                value: 0,
                repeat: 0,
                repeat_times: 1,
                repeat_type: 2,
                status: 2,
            },
            selectors: {
                typeDiv: '#repeatOptions',
                repeatDiv: '.repeatDiv',
                moneyInput: '#money',
                dateInput: '#dateRegistry'
            },
            errors: {
                name: '',
                date: '',
                value: '',
                repeat_times: '',
                status: '',
            }
        }
    },
    mounted() {
        this.changeType();
        this.changeRepeat();
    },
    methods: {
        changeType(option = null) {
            if (option === 2) {
                this.formData.type = 2;
                $(this.selectors.typeDiv).show();
                return;
            }
            this.formData.type = 1;
            $(this.selectors.typeDiv).hide();
        },
        changeRepeat() {
            if (!this.formData.repeat) {
                $(this.selectors.repeatDiv).hide();
                return;
            }
            $(this.selectors.repeatDiv).show();
        },
        setValueField() {
            this.formData.value = $(this.selectors.moneyInput).val();
            this.formData.date = $(this.selectors.dateInput).val();
            this.formData.repeat = this.formData.repeat ? 1 : 0;
        },
        saveAndInsert() {
            this.save(false);

            $(this.selectors.moneyInput).val('');
            $(this.selectors.dateInput).val('');
            this.formData = {
                name: '',
                type: 1,
                date: '',
                value: 0,
                repeat: 0,
                repeat_times: 1,
                repeat_type: 2,
                status: 2,
            };
        },
        save(redirect = true) {
            this.resetErrorFields();
            this.setValueField();

            this.axios.post('/admin/profits/create', this.formData).then((result) => {
                this.$toast.open(result.data.msg);

                if (redirect) {
                    window.location.href = '/admin/profits';
                }
            }).catch((error) => {
                this.getErrors(error.response.data);
            });
        },
        back() {
            window.location.href = '/admin/profits';
        },
        getErrors(error) {
            if (error.errors !== null && error.errors !== undefined) {
                Object.entries(error.errors).forEach(([key, value]) => {
                    this.$toast.error(value[0]);
                    this.errors[key] = 'is-invalid state-invalid';
                });
            }
        },
        resetErrorFields() {
            this.errors = {
                name: '',
                date: '',
                value: '',
                repeat_times: '',
                status: ''
            }
        }
    }
}
</script>

<style scoped>

</style>
