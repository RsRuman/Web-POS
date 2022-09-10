<template>
    <admin-layout>
        <section class="pt-20">
            <div class="container mx-auto px-7">
                <div class="flex gap-x-4 items-center">
                    <div class="text-2xl font-normal">Edit Customer</div>
                    <div class="text-4xl font-thin">|</div>
                    <div class="flex gap-x-3 items-center">
                        <Link :href="route('admin.dashboard')" class="text-cyan-300">Dashboard</Link>
                        <div>-
                            <Link :href="route('admin.client.index')" class="ml-1">Customer List</Link>
                            <span class="ml-3"> - Edit Customer</span>
                        </div>
                    </div>
                </div>
                <div class="w-full flex flex-col lg:flex-row gap-3 justify-between mt-5 pb-10">
                    <div class="w-full">
                        <form @submit.prevent="submit" class="bg-white rounded-md py-2 px-4 shadow-md">
                            <div class="px-4">

                                <div class="flex justify-between gap-x-8 mt-2">
                                    <div class="mt-1 w-full">
                                        <div class="required">Name</div>
                                        <input v-model="form.name" class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none mt-1 placeholder:text-sm"
                                               type="text" placeholder="Client Name">
                                        <div v-if="form.errors.name" class="text-red-500 px-2 py-1 text-sm">{{ form.errors.name }}</div>
                                    </div>
                                    <div class="mt-1 w-full">
                                        <div class="required">Email</div>
                                        <input v-model="form.email" class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none mt-1 placeholder:text-sm"
                                               type="email" placeholder="Client email">
                                        <div v-if="form.errors.email" class="text-red-500 px-2 py-1 text-sm">{{ form.errors.email }}</div>
                                    </div>
                                    <div class="mt-1 w-full">
                                        <div class="required">Phone No</div>
                                        <input v-model="form.phone_no" class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none mt-1 placeholder:text-sm"
                                               type="text" placeholder="Client phone">
                                        <div v-if="form.errors.phone_no" class="text-red-500 px-2 py-1 text-sm">{{ form.errors.phone_no }}</div>
                                    </div>
                                </div>

                                <div class="flex justify-between gap-x-8 mt-2">
                                    <div class="mt-1">
                                        <div class="required">Business Organization Name</div>
                                        <input v-model="form.bus_name" class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none mt-1 placeholder:text-sm"
                                               type="text" placeholder="Client business name">
                                        <div v-if="form.errors.bus_name" class="text-red-500 px-2 py-1 text-sm">{{ form.errors.bus_name }}</div>
                                    </div>
                                </div>

                                <div class="flex justify-between gap-x-8 mt-2">
                                    <div class="mt-1 w-full">
                                        <div class="required">Business Email</div>
                                        <input v-model="form.bus_email" class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none mt-1 placeholder:text-sm"
                                               type="email" placeholder="Business email">
                                        <div v-if="form.errors.bus_email" class="text-red-500 px-2 py-1 text-sm">{{ form.errors.bus_email }}</div>
                                    </div>
                                    <div class="mt-1 w-full">
                                        <div class="required">Business Phone</div>
                                        <input v-model="form.bus_phone_no" class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none mt-1 placeholder:text-sm"
                                               type="text" placeholder="Business phone">
                                        <div v-if="form.errors.bus_phone_no" class="text-red-500 px-2 py-1 text-sm">{{ form.errors.bus_phone_no }}</div>

                                    </div>
                                    <div class="mt-1 w-full">
                                        <div class="required">Credit Limit</div>
                                        <select v-model="form.bus_type" class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none mt-1 placeholder:text-sm">
                                            <option value="" selected disabled>Select Business Type</option>
                                            <option :value="1">Retailer</option>
                                            <option :value="2">WholeSeller</option>
                                            <option :value="3">Manufacturer</option>
                                        </select>
                                        <div v-if="form.errors.bus_type" class="text-red-500 px-2 py-1 text-sm">{{ form.errors.bus_type }}</div>
                                    </div>
                                </div>

                                <div class="flex justify-between gap-x-8 mt-2">
                                    <div class="flex justify-between gap-x-8 w-full">
                                        <div class="mt-1 w-full">
                                            <div>District</div>
                                            <select v-model="form.district_id" class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none mt-1 placeholder:text-sm">
                                                <option value="" selected disabled>Select District</option>
                                                <option :value="1">Dhaka</option>
                                                <option :value="2">Sherpur</option>
                                            </select>
                                            <div v-if="form.errors.district_id" class="text-red-500 px-2 py-1 text-sm">{{ form.errors.district_id }}</div>
                                        </div>
                                        <div class="mt-1 w-full">
                                            <div>Upazila</div>
                                            <select v-model="form.upazila_id" class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none mt-1 placeholder:text-sm">
                                                <option value="" selected disabled>Select Upazila</option>
                                                <option :value="1">Dhanmondi</option>
                                                <option :value="2">Shyamoli</option>
                                                <option :value="3">Sreebardi</option>
                                                <option :value="4">Jhinaigati</option>
                                            </select>
                                            <div v-if="form.errors.upazila_id" class="text-red-500 px-2 py-1 text-sm">{{ form.errors.upazila_id }}</div>
                                        </div>
                                        <div class="mt-1 w-full">
                                            <div class="required">Postal Code</div>
                                            <input v-model="form.postal_code" class="w-full px-4 py-2 border border-gray-300 rounded-md text-gray-900 focus:outline-none mt-1 placeholder:text-sm"
                                                   type="text" placeholder="Postal Code">
                                            <div v-if="form.errors.postal_code" class="text-red-500 px-2 py-1 text-sm">{{ form.errors.postal_code }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit and cancel button start-->
                            <div>
                                <div class="flex w-full mt-8 justify-end">
                                    <div class="w-2/12 flex flex-col gap-3 md:flex-row">
                                        <div class="flex items-center rounded-md bg-red-500 hover:bg-red-700 text-white transition-all w-full py-2 justify-center gap-x-2">
                                            <i class="fa-solid fa-xmark"></i>
                                            <Link :href="route('admin.client.index')" class="flex items-center cursor-pointer justify-center">
                                                Cancel
                                            </Link>
                                        </div>
                                        <div class="flex items-center rounded-md bg-blue-500 hover:bg-blue-700 text-white transition-all w-full py-2 justify-center gap-x-2">
                                            <i class="fa-regular fa-square-check"></i>
                                            <button type="submit" class="flex items-center cursor-pointer justify-center">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Submit and cancel button end-->
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </admin-layout>
</template>

<script>
import AdminLayout from "../Layout/Admin/AdminLayout";
import {Link, useForm} from '@inertiajs/inertia-vue3';
export default {
    name: "EditClient",
    components: {
        AdminLayout,
        Link
    },

    props: {
        client: Object
    },

    setup(){
        const form = useForm({
            name: '',
            email: '',
            phone_no: '',
            bus_name: '',
            bus_email: '',
            bus_phone_no: '',
            bus_type: '',
            district_id: '',
            upazila_id: '',
            postal_code: ''
        })

        return { form }
    },

    mounted() {
        this.setFormData(this.client.data);
    },

    methods: {
        setFormData(client){
            this.form.name = client.name;
            this.form.email = client.email;
            this.form.phone_no = client.phone;
            this.form.bus_name = client.businessOrganization.businessName;
            this.form.bus_email = client.businessOrganization.businessEmail;
            this.form.bus_phone_no = client.businessOrganization.businessPhoneNo;
            this.form.bus_type = client.businessOrganization.businessType;
            this.form.district_id = client.businessOrganization.districtId;
            this.form.upazila_id = client.businessOrganization.upazilaId;
            this.form.postal_code = client.businessOrganization.postalCode;
        },

        submit(){
            this.form.put(route('admin.client.update', this.client.data.id),{
                preserveScroll: true,
                onSuccess: () => {
                    this.$swal.fire({
                        title: 'Success!',
                        text: 'Client and Business updated successful',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                },
                onError: () => {
                    this.$swal.fire({
                        title: 'Error!',
                        text: 'Something goes wrong. Please try again',
                        icon: 'error',
                        showConfirmButton: false,
                        timer: 1500
                    })
                },
            })
        }
    }
}
</script>

<style scoped>
.required:after {
    content:" *";
    color: red;
    margin-left: 1px;
}
</style>
