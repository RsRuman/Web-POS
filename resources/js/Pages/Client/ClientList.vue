<template>
    <admin-layout>
        <section class="pt-20">
            <div class="container mx-auto px-7">
                <div class="flex gap-x-4 items-center">
                    <div class="text-2xl font-normal">Customer List</div>
                    <div class="text-4xl font-thin">|</div>
                    <div class="flex gap-x-3 items-center mt-0.5">
                        <Link :href="route('admin.dashboard')" class="text-cyan-300">Dashboard</Link>
                        <div>-
                            <span class="ml-1">Customer List</span>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col lg:flex-row gap-3 justify-between mt-8 pb-10">
                    <div class="w-full">
                        <div class="bg-white shadow rounded-md">
                            <!-- table content -->
                            <div class="flex justify-between items-center pt-2">
                                <h4 class="text-lg pl-4">Customer List</h4>
                                <div class="flex mt-1 items-center  text-white w-2/12 transition-all justify-center">
                                    <Link :href="route('admin.client.create')" class="flex items-center cursor-pointer justify-center rounded bg-blue-600 py-2 px-4 transition-all overflow-hidden hover:bg-blue-800">
                                        Add Customer
                                    </Link>
                                </div>
                            </div>
                            <div class="overflow-auto scroller mt-7 px-4 pb-4">
                                <table class="table-auto min-w-max">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Client Name</th>
                                        <th>Client Email</th>
                                        <th>Client Phone</th>
                                        <th>Business Name</th>
                                        <th>Business Type</th>
                                        <th>Business Email</th>
                                        <th>Business Phone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(client, cIdx) in users" :key="'client'+cIdx" class="text-sm">
                                        <td>{{ cIdx }}</td>
                                        <td>{{ client.name }}</td>
                                        <td>{{ client.email }}</td>
                                        <td>{{ client.phone }}</td>
                                        <td>{{ client?.businessOrganization?.businessName }}</td>
                                        <td>{{ client?.businessOrganization?.businessTypeLabel }}</td>
                                        <td>{{ client?.businessOrganization?.businessEmail }}</td>
                                        <td>{{ client?.businessOrganization?.businessPhoneNo }}</td>
                                        <td>{{ client?.businessOrganization?.statusLabel }}</td>
                                        <td>
                                            <div class="flex w-full">
                                                <div class="flex items-center rounded-md bg-blue-300 hover:bg-blue-400 text-white transition-all w-full py-1 justify-center gap-x-2">
                                                    <Link :href="route('admin.client.edit', client.id)" class="flex items-center cursor-pointer justify-center px-2">Edit</Link>
                                                </div>
                                                <div class="flex items-center rounded-md bg-red-500 hover:bg-red-600 text-white transition-all w-full py-1 justify-center gap-x-2 ml-1">
                                                    <button @click.prevent="deleteClient(client.id)" class="flex items-center cursor-pointer justify-center px-2">Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- table content -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </admin-layout>
</template>

<script>
import AdminLayout from "../Layout/Admin/AdminLayout";
import {Link} from "@inertiajs/inertia-vue3";
export default {
    name: "ClientList",
    components: {
        AdminLayout,
        Link
    },

    props: {
        clients: Object
    },

    data(){
        return{
            users: []
        }
    },

    mounted() {
        this.users = this.clients.data;
    },

    methods: {
        deleteClient(id){
            this.$swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                     axios.delete(route('admin.client.destroy', id))
                        .then((response) => {
                            if (response.data.status === 200){
                                const index = this.users.map((item) => item.id).indexOf(id);
                                this.users.splice(index, 1);
                                this.$swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                            }else{
                                this.$swal.fire(
                                    'Error!',
                                    'Something went wrong. Please try again',
                                    'error'
                                )
                            }
                        })
                }
            })
        }
    }
}
</script>

<style scoped>
</style>
