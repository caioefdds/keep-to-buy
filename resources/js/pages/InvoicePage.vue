<template>
    <!-- ROW-1 OPEN -->
    <div class="row">
        <!-- Row -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12 mb-5">
                            <div class="d-flex justify-content-center">
                                <div class="d-flex">
                                    <button class="arrow_month_button">
                                        <i class="fa fa-chevron-left"></i>
                                    </button>
                                </div>
                                <div class="month_name">
                                    <button class="month_button">
                                        <i aria-label="fa fa-calendar-o" class="fa fa-calendar-o"></i>&nbsp&nbsp
                                        JANEIRO
                                    </button>
                                </div>
                                <div class="d-flex">
                                    <button class="arrow_month_button">
                                        <i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap border-bottom w-100" id="responsive-datatable">
                                <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">Situação</th>
                                    <th class="wd-15p border-bottom-0">Data</th>
                                    <th class="wd-20p border-bottom-0">Descrição</th>
<!--                                    <th class="wd-15p border-bottom-0">Categoria</th>-->
                                    <th class="wd-15p border-bottom-0">Valor</th>
<!--                                    <th class="wd-15p border-bottom-0">Parcelas</th>-->
                                    <th class="wd-15p border-bottom-0">Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item in dataTable" :class="(parseInt(item.record_type) === 1) ? 'bg-profit' : 'bg-expense'">
                                    <td v-if="parseInt(item.record_type) === 1">
                                        <div class="d-flex" v-if="parseInt(item.status) === 1">
                                            <a href="#" class="icons-table-b text-success" @click="receiveRegistry(item.id, 1)">
                                                <i class="side-menu__icon fa fa-money"></i>
                                            </a>
                                            <div class="m-auto">RECEBIDO</div>
                                        </div>
                                        <div class="d-flex" v-else>
                                            <a href="#" class="icons-table-b text-dark" @click="receiveRegistry(item.id, 2)">
                                                <i class="side-menu__icon fa fa-money"></i>
                                            </a>
                                            <div class="m-auto">PENDENTE</div>
                                        </div>
                                    </td>
                                    <td v-else>
                                        <div class="d-flex" v-if="parseInt(item.status) === 1">
                                            <a href="#" class="icons-table-b text-danger" @click="payRegistry(item.id, 1)">
                                                <i class="side-menu__icon fa fa-money"></i>
                                            </a>
                                            <div class="m-auto">PAGO</div>
                                        </div>
                                        <div class="d-flex" v-else>
                                            <a href="#" class="icons-table-b text-dark" @click="payRegistry(item.id, 2)">
                                                <i class="side-menu__icon fa fa-money"></i>
                                            </a>
                                            <div class="m-auto">PENDENTE</div>
                                        </div>
                                    </td>
                                    <td>{{ item.date }}</td>
                                    <td>{{ item.name }}</td>
<!--                                    <td>{{ item.category }}</td>-->
                                    <td>{{ floatToMoney(item.value) }}</td>
<!--                                    <td>{{ item.repeat }}</td>-->
<!--                                    <td>{{ item.repeat_times }}</td>-->
                                    <td v-if="parseInt(item.record_type) === 1" class="d-flex justify-content-center p-auto">

                                        <a href="#" class="icons-table text-warning" @click="editRegistry(item.id)">
                                            <i class="side-menu__icon fa fa-edit"></i>
                                        </a>
                                        <a href="" data-bs-target="#modalDelete" data-bs-toggle="modal" class="icons-table text-danger">
                                            <i class="side-menu__icon fa fa-trash" @click="setDeleteId(item.id)"></i>
                                        </a>
                                    </td>
                                    <td v-else class="d-flex justify-content-center p-auto">
                                        <a href="#" class="icons-table text-warning" @click="editRegistry(item.id)">
                                            <i class="side-menu__icon fa fa-edit"></i>
                                        </a>
                                        <a href="" data-bs-target="#modalDelete" data-bs-toggle="modal" class="icons-table text-danger">
                                            <i class="side-menu__icon fa fa-trash" @click="setDeleteId(item.id)"></i>
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade"  id="modalDelete">
            <div class="modal-dialog modal-dialog-centered text-center " role="document">
                <div class="modal-content tx-size-sm">
                    <div class="modal-body text-center p-4">
                        <button aria-label="Close" class="btn-close" data-bs-dismiss="modal" @click="removeDeleteId()"><span aria-hidden="true">&times;</span></button>
                        <i class="fe fe-x-square fs-100 text-danger lh-1 mb-5 d-inline-block"></i>
                        <h4 class="text-danger tx-semibold">Você realmente deseja excluir?</h4>
                        <p class="mg-b-20 mg-x-20">Ao excluir todos registros relacionados serão excluídos.</p>
                        <button class="btn btn-danger pd-x-25" data-bs-dismiss="modal" @click="removeDeleteId()">Cancelar</button>
                        <button class="btn btn-success pd-x-25" data-bs-dismiss="modal" @click="deleteRegistry()">Prosseguir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "index",
    props: {
        data: {
            default: () => []
        }
    },
    data() {
        return {
            dataTable: JSON.parse(this.data),
            deleteId: null
        }
    },
    mounted() {
        console.log(this.dataTable)
    },
    methods: {
        setDeleteId(id) {
            this.deleteId = id;
        },
        removeDeleteId() {
            this.deleteId = null;
        },
        floatToMoney(value) {
            return value.toLocaleString(
                'pt-br', {
                    style: 'currency', currency: 'BRL'
                }
            );
        },
        deleteRegistry() {
            this.axios.delete('/admin/expenses/delete', {
                data: {
                    id: this.deleteId
                }
            }).then((response) => {
                this.$toast.open(response.data.msg);
                window.location.reload();
            }).catch((error) => {
                this.$toast.error(error.response.data.msg);
            });
        },
        payRegistry() {
            this.axios.delete('/admin/expenses/delete', {
                data: {
                    id: this.deleteId
                }
            }).then((response) => {
                this.$toast.open(response.data.msg);
                window.location.reload();
            }).catch((error) => {
                this.$toast.error(error.response.data.msg);
            });
        },
        receiveRegistry() {
            this.axios.delete('/admin/expenses/delete', {
                data: {
                    id: this.deleteId
                }
            }).then((response) => {
                this.$toast.open(response.data.msg);
                window.location.reload();
            }).catch((error) => {
                this.$toast.error(error.response.data.msg);
            });
        },
        editRegistry(id) {
            window.location.href = '/admin/expenses/edit/' + id
        },
    }
}
</script>

<style scoped>
.icons-table {
    font-size: 1.2rem;
    padding: 0 0.3rem;
}
.icons-table-b {
    font-size: 1.6rem;
    padding: 0 0.3rem;
}
.bg-expense {
    background-color: rgb(255 0 0 / 5%);
    border: 1px solid red;
}
.bg-profit {
    background-color: rgb(0 255 55 / 5%);
    border: 1px solid green;
}
.table-bordered, .text-wrap table, .table-bordered th, .text-wrap table th, .table-bordered td, .text-wrap table td {
    border: none;
}
.month_button {
    padding: 0.4rem 1.6rem;
    background-color: #7d6edd;
    border: none;
    margin: auto;
    font-weight: 400;
    font-size: 1.3rem;
    color: white;
    border-radius: 2rem;
}

.arrow_month_button {
    border: none;
    background-color: transparent;
    margin: auto;
    font-size: 1.6rem;
    color: #7d6edd;
}

</style>
