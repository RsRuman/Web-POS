<template>
    <admin-layout>
        <section class="pt-20">
            <div class="container mx-auto px-7">
                <div class="flex gap-x-4 items-center">
                    <div class="text-2xl font-normal">Size List</div>
                    <div class="text-4xl font-thin">|</div>
                    <div class="flex gap-x-3 items-center mt-0.5">
                        <Link :href="route('admin.dashboard')" class="text-cyan-300">Dashboard</Link>
                        <div>-
                            <span class="ml-1">Size List</span>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col lg:flex-row gap-3 justify-between mt-8 pb-10">
                    <div class="w-full">
                        <div class="bg-white shadow rounded-md">

                            <!-- table content -->
                            <div class="flex justify-between items-center pt-2">
                                <h4 class="text-lg pl-4">Size List</h4>
                                <div class="flex mt-1 items-center  text-white w-2/12 transition-all justify-center">
                                    <button @click.prevent="setEditSize({})" type="button"
                                            class="flex items-center cursor-pointer justify-center rounded bg-blue-600 py-2 px-4 transition-all overflow-hidden hover:bg-blue-800"
                                            id="openModal"
                                            data-bs-toggle="modal" data-bs-target="#sizeModal">
                                        Add Size
                                    </button>
                                </div>
                            </div>

                            <div class="overflow-auto scroller mt-7 px-4 pb-4">
                                <table class="table-auto min-w-max">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Size Name</th>
                                        <th>Short Form</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(size, uIdx) in sizes" :key="'size'+uIdx" class="text-sm">
                                        <td>{{ uIdx }}</td>
                                        <td>{{ size.sizeName }}</td>
                                        <td>{{ size.shortForm }}</td>
                                        <td>{{ size.statusLabel }}</td>
                                        <td>
                                            <div class="flex w-full">
                                                <div class="flex items-center rounded-md bg-blue-300 hover:bg-blue-400 text-white transition-all w-full py-1 justify-center gap-x-2">
                                                    <button @click.prevent="setEditSize(size)" class="flex items-center cursor-pointer justify-center px-2">Edit</button>
                                                </div>
                                                <div class="flex items-center rounded-md bg-red-500 hover:bg-red-600 text-white transition-all w-full py-1 justify-center gap-x-2 ml-1">
                                                    <button @click.prevent="deleteSize(size)" class="flex items-center cursor-pointer justify-center px-2">Delete</button>
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
        <size-modal :size="size"></size-modal>
    </admin-layout>
</template>

<script>
import AdminLayout from "../Layout/Admin/AdminLayout";
import SizeModal from "../Components/Modals/SizeModal";
export default {
    name: "Size",
    components: {SizeModal, AdminLayout},

    props: {
        sizeList: Object
    },

    data(){
        return{
            sizes: [],

            size: {}
        }
    },

    mounted() {
        this.sizes = this.sizeList.data;
    },

    methods: {
        deleteSize(size){
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
                    axios.delete(route('admin.size.destroy', size.id))
                        .then((response) => {
                            if (response.data.status === 200){
                                const index = this.sizes.map((item) => item.id).indexOf(size.id);
                                this.sizes.splice(index, 1);
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
        },

        setEditSize(size){
            document.getElementById('openModal').click();
            this.size = size;

        }
    },

    computed: {
        checkSizeList(){
            return JSON.parse(JSON.stringify(this.sizeList));
        }
    },

    watch: {
        checkSizeList: {
            handler(newValue, oldValue){
                if (newValue !== oldValue){
                    this.sizes = this.sizeList.data;
                }
            },
            deep: true
        }
    }
}
</script>

<style scoped>

</style>
