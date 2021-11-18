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
                                            <a href="#" class="icons-table text-danger" @click="deleteRegistry(item.id)">
                                                <i class="side-menu__icon fa fa-trash"></i>
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
        <!-- End Row -->
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
            dataTable: JSON.parse(this.data)
        }
    },
    methods: {
        deleteRegistry(id) {
            this.axios.delete('/admin/profits/delete', {
                data: {
                    id: id
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
