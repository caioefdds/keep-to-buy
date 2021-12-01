<template>
    <div class="container-login100">
        <div class="wrap-login100 p-0">
            <div class="card-body">
                <form class="login100-form validate-form">
									<span class="login100-form-title">
										Cadastrar
									</span>

                    <div class="wrap-input100 validate-input" data-bs-validate="Insira um nome válido - ex.: Caio">
                        <input :class="'input100 form-control ' + errors.name" name="name" placeholder="Nome" type="text" v-model="name" v-on:keyup.enter="save">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i aria-hidden="true" class="mdi mdi-account"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input"
                         data-bs-validate="Insira um e-mail válido - ex.: usuario@gmail.com">
                        <input :class="'input100 form-control ' + errors.email" name="email" placeholder="E-mail" type="text" v-model="email" v-on:keyup.enter="save">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i aria-hidden="true" class="zmdi zmdi-email"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-bs-validate="Senha é obrigatória">
                        <input :class="'input100 form-control ' + errors.password" name="password" placeholder="Senha" type="password" v-model="password" v-on:keyup.enter="save">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i aria-hidden="true" class="zmdi zmdi-lock"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-bs-validate="Senha é obrigatória">
                        <input :class="'input100 form-control ' + errors.password2" name="password2" placeholder="Confirmação de senha" type="password" v-model="password2" v-on:keyup.enter="save">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i aria-hidden="true" class="zmdi zmdi-lock"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn" @click="save()">
                        <a class="login100-form-btn btn-primary">
                            Registrar
                        </a>
                    </div>
                    <div class="text-center pt-3">
                        <p class="text-dark mb-0">Já possui conta?<a class="text-primary ms-1" href="/login">Entrar</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "RegisterPage",
    data() {
        return {
            name: "",
            email: "",
            password: "",
            password2: "",
            errors: {
                name: '',
                email: '',
                password: '',
                password2: '',
            }
        }
    },
    methods: {
        async save() {
            this.resetErrorFields();
            await this.axios.post('/register', {
                name: this.name,
                email: this.email,
                password: this.password,
                password2: this.password2
            }).then((result) => {
                if (result.status === 201) {
                    this.$toast.open(result.data.msg);
                    window.location.href = '/admin/index';
                }
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
                name: '',
                email: '',
                password: '',
                password2: '',
            }
        }
    }
}
</script>

<style scoped>

</style>
