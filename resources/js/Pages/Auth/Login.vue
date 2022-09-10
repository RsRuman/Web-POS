<template>
    <section class="h-auto mix-blend-darken:h-screen bg-gradient-to-r from-[#001527] to-[#000a27]">
        <div class="container h-full px-6 py-6 mx-auto md:py-0">
            <div
                class="flex flex-col items-center justify-center h-auto gap-4 md:gap-6 md:h-full md:flex-row lg:gap-10">
                <div class="w-full overflow-hidden md:h-screen h-72 md:w-6/12 lg:w-7/12 2xl:w-8/12">
                    <div id="carouselExampleCaptions" class="relative h-full overflow-hidden carousel slide"
                         data-bs-ride="carousel">
                        <div class="absolute bottom-0 left-0 right-0 flex justify-center p-0 mb-4 carousel-indicators">
                            <button aria-current="true" aria-label="Slide 1" class="active"
                                    data-bs-slide-to="0"
                                    data-bs-target="#carouselExampleCaptions" type="button"></button>
                            <button aria-label="Slide 2" data-bs-slide-to="1" data-bs-target="#carouselExampleCaptions"
                                    type="button"></button>
                            <button aria-label="Slide 3" data-bs-slide-to="2" data-bs-target="#carouselExampleCaptions"
                                    type="button"></button>
                        </div>
                        <div class="relative w-full h-full overflow-hidden carousel-inner">
                            <div class="relative float-left w-full h-full carousel-item active">
                                <div class="relative object-cover h-full overflow-hidden bg-no-repeat bg-cover"
                                     style="background-position: 50%;">
                                    <img class="block object-cover w-full h-full"
                                         src="https://mdbootstrap.com/img/Photos/Slides/img%20(123).jpg"/>
                                    <div
                                        class="absolute top-0 bottom-0 left-0 right-0 w-full h-full overflow-hidden bg-fixed bg-black opacity-50">
                                    </div>
                                </div>
                                <div class="absolute hidden text-center carousel-caption md:block">
                                    <h5 class="text-xl">First slide label</h5>
                                    <p>Some representative placeholder content for the first slide.</p>
                                </div>
                            </div>
                            <div class="relative float-left w-full h-full carousel-item">
                                <div class="relative h-full overflow-hidden bg-no-repeat bg-cover"
                                     style="background-position: 50%;">
                                    <img class="block object-cover w-full h-full"
                                         src="https://mdbootstrap.com/img/Photos/Slides/img%20(124).jpg"/>
                                    <div
                                        class="absolute top-0 bottom-0 left-0 right-0 w-full h-full overflow-hidden bg-fixed bg-black opacity-50">
                                    </div>
                                </div>
                                <div class="absolute hidden text-center carousel-caption md:block">
                                    <h5 class="text-xl">Second slide label</h5>
                                    <p>Some representative placeholder content for the second slide.</p>
                                </div>
                            </div>
                            <div class="relative float-left w-full h-full carousel-item">
                                <div class="relative h-full overflow-hidden bg-no-repeat bg-cover"
                                     style="background-position: 50%;">
                                    <img class="block object-cover w-full h-full"
                                         src="https://mdbootstrap.com/img/Photos/Slides/img%20(125).jpg"/>
                                    <div
                                        class="absolute top-0 bottom-0 left-0 right-0 w-full h-full overflow-hidden bg-fixed bg-black opacity-50">
                                    </div>
                                </div>
                                <div class="absolute hidden text-center carousel-caption md:block">
                                    <h5 class="text-xl">Third slide label</h5>
                                    <p>Some representative placeholder content for the third slide.</p>
                                </div>
                            </div>
                        </div>
                        <button
                            class="absolute top-0 bottom-0 left-0 flex items-center justify-center p-0 text-center border-0 carousel-control-prev hover:outline-none hover:no-underline focus:outline-none focus:no-underline"
                            data-bs-slide="prev" data-bs-target="#carouselExampleCaptions" type="button">
                            <span aria-hidden="true"
                                  class="inline-block bg-no-repeat carousel-control-prev-icon"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button
                            class="absolute top-0 bottom-0 right-0 flex items-center justify-center p-0 text-center border-0 carousel-control-next hover:outline-none hover:no-underline focus:outline-none focus:no-underline"
                            data-bs-slide="next" data-bs-target="#carouselExampleCaptions" type="button">
                            <span aria-hidden="true"
                                  class="inline-block bg-no-repeat carousel-control-next-icon"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="w-full shadow rounded-md p-4 sm:p-6 text-white md:w-6/12 lg:w-5/12 2xl:w-4/12"
                     style="background-color: rgba(106, 106, 106, 0.2);">

                    <!-- Login form start -->
                    <form @submit.prevent="submit">
                        <h2 class="py-0 text-5xl font-medium sm:py-4">Login</h2>
                        <div class="mx-auto">
                            <div class="py-2">
                                <span class="px-1 font-medium">E-mail</span>
                                <input v-model="form.email" class="block w-full px-3 text-primary py-3 mt-2 placeholder-gray-400 bg-white border border-gray-300 rounded-lg text-md focus:placeholder-gray-500 focus:outline-none" placeholder="name@gmail.com"
                                       type="text">
                                <div v-if="form.errors.email" class="text-red-500 px-2 py-1 text-sm">
                                    {{ form.errors.email }}
                                </div>
                            </div>
                            <div class="py-2">
                                <span class="px-1 font-medium">Password</span>
                                <div class="relative">
                                    <input id="password" v-model="form.password"
                                           class="block w-full text-primary px-3 py-3 mt-2 placeholder-gray-400 bg-white border border-gray-300 rounded-lg focus:placeholder-gray-500 text-md focus:outline-none"
                                           placeholder="6+ character, 1 capital letter">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-xl leading-5">
                                        <i id="toggle-password" class="fa-solid fa-eye-slash"></i>
                                    </div>
                                    <div v-if="form.errors.password" class="text-red-500 px-2 py-1 text-sm">{{ form.errors.password }}</div>
                                </div>
                            </div>
                            <div v-if="$page.props.errors.cred" class="text-red-500 px-2 text-sm">{{
                                    $page.props.errors.cred
                                }}
                            </div>
                            <div class="flex justify-between">
                                <label class="flex items-center gap-2 my-4 font-bold text-white">
                                    <input class="w-5 h-5 leading-loose" type="checkbox">
                                    <span> Remember Me </span>
                                </label>
                                <label class="block my-4 font-bold text-white">
                                    <a class="tracking-tighter border-b-2 border-gray-200 cursor-pointer hover:border-gray-400"
                                       href="#">
                                        <span>Forgot Password?</span>
                                    </a>
                                </label>
                            </div>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="block w-full px-6 py-3 mt-3 text-lg font-semibold text-white rounded-lg shadow-xl bg-secondary transition-all hover:text-white bg-blue-500 hover:bg-blue-600">
                                Login
                            </button>
                        </div>
                    </form>
                    <!-- Login form end -->
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import {useForm} from '@inertiajs/inertia-vue3'

export default {
    name: "Login",

    setup() {
        const form = useForm({
            email: null,
            password: null,
            remember: false,
        })

        return {form}
    },

    methods: {
        submit() {
            this.form.post(route('admin.login'), {
                preserveScroll: true,
                onSuccess: () => this.form.reset('password'),
                onError: () => this.form.reset('password'),
            })
        }
    }
}
</script>

<style scoped>

</style>
