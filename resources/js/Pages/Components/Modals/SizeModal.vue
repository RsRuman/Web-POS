<template>
    <!-- Modal -->
    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
         id="sizeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="sizeModalLabel" aria-hidden="true">
        <div class="modal-dialog relative w-auto pointer-events-none">
            <div
                class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="sizeModalLabel">
                        Paymaster Size
                    </h5>
                    <button type="button"
                            @click.prevent="hideModal"
                            class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none
                            focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline fa fa-beat"
                            id="close"
                            data-bs-dismiss="modal">X</button>
                </div>

                <div class="modal-body relative p-4">
                    <div class="mt-1 w-full">
                        <div class="required">Size Name</div>
                        <input v-model="form.size_name"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none mt-1 placeholder:text-sm"
                               type="text" placeholder="Product Name">
                        <div v-if="form.errors.size_name" class="text-red-500 px-2 py-1 text-sm">{{ form.errors.size_name }}</div>
                    </div>
                    <div class="mt-1 w-full">
                        <div class="required">Short Name</div>
                        <input v-model="form.short_form"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none mt-1 placeholder:text-sm"
                               type="text" placeholder="Product Name">
                        <div v-if="form.errors.short_form" class="text-red-500 px-2 py-1 text-sm">{{ form.errors.short_form }}</div>
                    </div>
                </div>

                <div
                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <button type="button"
                            @click.prevent="hideModal"
                            class="inline-block px-6 py-2.5 bg-purple-600 text-white font-medium text-xs
                            leading-tight uppercase rounded shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700
                             focus:shadow-lg focus:outline-none focus:ring-0 active:bg-purple-800 active:shadow-lg transition duration-150 ease-in-out">
                        Cancel
                    </button>
                    <button type="button"
                            :disabled="form.processing"
                            @click.prevent="submit()"
                            class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded
                            shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
                            active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ml-1">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";

export default {
    name: "SizeModal",

    props: {
        size: Object
    },

    setup(){
        const form = useForm({
            id: '',
            size_name: '',
            short_form: ''
        })

        return { form }
    },

    methods: {
        hideModal(){
            document.getElementById('close').click();
            this.form.errors = Object.assign({});
        },

        submit(){
            if (this.form.id === ''){
                this.form.post(route('admin.size.store'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        document.getElementById('close').click();
                        this.form.reset();
                        this.$swal.fire({
                            title: 'Success!',
                            text: 'Size created successfully',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    onError: () => {
                        this.$swal.fire({
                            title: 'Error!',
                            text: 'Please provide valid data',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                })
            } else {
                this.form.put(route('admin.size.update', this.form.id), {
                    preserveScroll: true,
                    onSuccess: () => {
                        document.getElementById('close').click();
                        this.form.reset();
                        this.$swal.fire({
                            title: 'Success!',
                            text: 'Size updated successfully',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    onError: () => {
                        this.$swal.fire({
                            title: 'Error!',
                            text: 'Please provide valid data',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                })
            }

        },
    },

    computed: {
        checkSize(){
            return JSON.parse(JSON.stringify(this.size));
        }
    },

    watch: {
        checkSize: {
            handler(newValue, oldValue) {
                if (newValue !== oldValue){
                    this.form.id = this.size.id ? this.size.id : '';
                    this.form.size_name = this.size.sizeName ? this.size.sizeName : '';
                    this.form.short_form = this.size.shortForm ? this.size.shortForm : '';
                }
            },
            deep: true
        }
    }
}
</script>

<style scoped>

</style>
