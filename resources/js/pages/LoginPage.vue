<template>
    <div class="container-login100">
        <div class="wrap-login100 p-0">
            <div class="card-body">
                <form class="login100-form validate-form">
                    <span class="login100-form-title">
                        Entrar
                    </span>

                    <div class="wrap-input100 validate-input" data-bs-validate = "Insira um e-mail válido - ex.: usuario@gmail.com">
                        <input :class="'input100 form-control ' + errors.email" type="text" name="email" placeholder="E-mail" v-model="email" v-on:keyup.enter="login">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="zmdi zmdi-email" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-bs-validate = "A senha é obrigatória">
                        <input :class="'input100 form-control ' + errors.password" type="password" name="pass" placeholder="Senha" v-model="password" v-on:keyup.enter="login">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="zmdi zmdi-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="text-end pt-1">
                        <p class="mb-0"><a href="/forgot-password" class="text-primary ms-1">Esqueceu sua senha?</a></p>
                    </div>

                    <div class="container-login100-form-btn" @click="login">
                        <a class="login100-form-btn btn-primary">
                            Login
                        </a>
                    </div>
                    <div class="text-center pt-3">
                        <p class="text-dark mb-0">Não possui conta?<a href="/register" class="text-primary ms-1">Crie sua conta</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "LoginPage",
    data() {
        return {
            email: "",
            password: "",
            errors: {
                email: '',
                password: '',
            }
        }
    },
    methods: {
        async login() {
            this.resetErrorFields();
            await this.axios.post('/login', {
                email: this.email,
                password: this.password
            }).then((result) => {
                this.$toast.open(result.data.msg);
                window.location.href = '/admin';
            }).catch((error) => {
                this.getErrors(error.response.data);
            });
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
                email: '',
                password: '',
            }
        }
    }
}
</script>

<style scoped>

</style>
