<template>
    <!-- ROW-1 OPEN -->
    <div class="row">
        <!-- Row -->
        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap border-bottom w-100" id="responsive-datatable">
                                <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">Nome</th>
                                    <th class="wd-15p border-bottom-0">Valor</th>
                                    <th class="wd-20p border-bottom-0">Data</th>
                                    <th class="wd-15p border-bottom-0">Status</th>
                                    <th class="wd-15p border-bottom-0">Repete</th>
                                    <th class="wd-15p border-bottom-0">Parcelas</th>
                                    <th class="wd-15p border-bottom-0">Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in dataTable">
                                        <td>{{ item.name }}</td>
                                        <td>{{ item.value }}</td>
                                        <td>{{ item.date }}</td>
                                        <td>{{ item.status }}</td>
                                        <td>{{ item.repeat }}</td>
                                        <td>{{ item.repeat_times }}</td>
                                        <td class="d-flex justify-content-center p-auto">
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
                        <p class="mg-b-20 mg-x-20">Ao prosseguir todos registros relacionados serão excluídos.</p>
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
    methods: {
        setDeleteId(id) {
            this.deleteId = id;
        },
        removeDeleteId() {
            this.deleteId = null;
        },
        deleteRegistry() {
            this.axios.post('/admin/profits/delete', {
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
            window.location.href = '/admin/profits/edit/' + id
        },
    }
}
</script>

<style scoped>

</style>
