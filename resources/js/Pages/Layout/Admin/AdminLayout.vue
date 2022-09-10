<template>
    <div class="sidebar close">
        <div class="logo-details relative">
            <i class='bx bxl-c-plus-plus'></i>
            <img alt="" class="logo_name" src="/images/Brainchild.png">
            <div
                class="home-content bg-secondary absolute flex justify-center items-center -right-20 z-50 cursor-pointer">
                <i class='bx bx-menu'></i>
            </div>
        </div>
        <ul class="nav-links">
            <li>
                <a href="#">
                    <i class='bx bx-grid-alt'></i>
                    <Link :href="route('admin.dashboard')" class="link_name">Dashboard</Link>
                </a>
                <ul class="sub-menu transition-all ">
                    <li><a class="link_name " href="#">Dashboard</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class="fa-solid fa-people-group"></i>
                        <span class="link_name text-sm">Client</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li>
                        <Link :href="route('admin.client.index')">Client List</Link>
                    </li>
                    <li>
                        <Link :href="route('admin.client.create')">Add New Client</Link>
                    </li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="#">
                        <i class="fa-solid fa-scale-balanced"></i>
                        <span class="link_name text-sm">Measurement</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu">
                    <li>
                        <Link :href="route('admin.unit.index')">Unit</Link>
                    </li>
                    <li>
                        <Link :href="route('admin.color.index')">Color</Link>
                    </li>
                    <li>
                        <Link :href="route('admin.size.index')">Size</Link>
                    </li>
                </ul>
            </li>
            <li>
                <div class="profile-details">
                    <div class="profile-content">
                        <img alt="profileImg" src="/images/profile.jpg">
                    </div>
                    <div class="name-job">
                        <div class="profile_name">Prem Shahi</div>
                        <div class="job">Web Desginer</div>
                    </div>
                    <i class='bx bx-log-out'></i>
                </div>
            </li>
        </ul>
    </div>
    <section class="home-section">
        <section class="relative">
            <!-- navbar start -->
            <nav class="bg-secondary fixed left-auto top-0 right-0 z-50 w-full">
                <div class="px-2 mx-auto max-w-[102rem] sm:px-6 lg:px-8">
                    <div class="relative flex items-center justify-between sm:justify-end h-16">
                        <div
                            class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                            <!-- Profile dropdown -->
                            <div
                                class="relative flex items-center ml-6 md:ml-2 xl:ml-4 2xl:ml-10 gap-x-2 md:gap-x-4 lg:gap-x-2 xl:gap-x-2">
                                <!-- Icon -->
                                <div class="relative dropdown">
                                    <div id="dropdownMenuButton1" aria-expanded="false"
                                         class="flex items-center mr-4 dropdown-toggle hidden-arrow"
                                         data-bs-toggle="dropdown" href="#"
                                         role="button">
                                        <svg class="w-10 h-10 text-white" fill="currentColor"
                                             viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path clip-rule="evenodd"
                                                  d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                                  fill-rule="evenodd"></path>
                                        </svg>
                                        <span
                                            class="text-white bg-red-500 absolute rounded-full text-xs -mt-6 ml-6 py-0 px-1.5 h-6 w-6 flex justify-center items-center border-2 border-white">12</span>
                                    </div>
                                    <ul aria-labelledby="dropdownMenuButton1"
                                        class="absolute divide-y left-auto z-50 hidden float-left m-0 mt-0 overflow-hidden text-base text-left list-none bg-white border-none rounded-lg shadow-lg -right-20 md:right-0 dropdown-menu w-52 bg-clip-padding">
                                        <li>
                                            <a class="block w-full px-4 py-2 font-normal bg-transparent  dropdown-item whitespace-nowrap hover:text-white hover:bg-blue-400"
                                               href="#">Action</a>
                                        </li>
                                        <li>
                                            <a class="block w-full px-4 py-2 text-lg font-normal bg-transparent  dropdown-item whitespace-nowrap hover:text-white hover:bg-blue-400"
                                               href="#">Another action</a>
                                        </li>
                                        <li>
                                            <a class="block w-full px-4 py-2 text-lg font-normal bg-transparent  dropdown-item whitespace-nowrap hover:text-white hover:bg-blue-400"
                                               href="#">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="relative dropdown">
                                    <div id="dropdownMenuButton1" aria-expanded="false"
                                         class="flex items-center mr-4 dropdown-toggle hidden-arrow"
                                         data-bs-toggle="dropdown" href="#"
                                         role="button">
                                        <svg aria-hidden="true" class="w-8 h-8 text-white" data-icon="bell"
                                             data-prefix="fas"
                                             focusable="false" role="img" viewBox="0 0 448 512"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M224 512c35.32 0 63.97-28.65 63.97-64H160.03c0 35.35 28.65 64 63.97 64zm215.39-149.71c-19.32-20.76-55.47-51.99-55.47-154.29 0-77.7-54.48-139.9-127.94-155.16V32c0-17.67-14.32-32-31.98-32s-31.98 14.33-31.98 32v20.84C118.56 68.1 64.08 130.3 64.08 208c0 102.3-36.15 133.53-55.47 154.29-6 6.45-8.66 14.16-8.61 21.71.11 16.4 12.98 32 32.1 32h383.8c19.12 0 32-15.6 32.1-32 .05-7.55-2.61-15.27-8.61-21.71z"
                                                fill="currentColor">
                                            </path>
                                        </svg>
                                        <span
                                            class="text-white bg-red-500 absolute rounded-full text-xs -mt-6 ml-4 py-0 px-1.5 h-6 w-6 flex justify-center items-center border-2 border-white">1</span>
                                    </div>
                                    <div
                                        aria-labelledby="dropdownMenuButton1"
                                        class="absolute left-auto z-50 hidden float-left m-0 mt-0 overflow-hidden text-base text-left list-none bg-white border-none rounded-lg shadow-lg -right-20 md:right-0 dropdown-menu w-72 md:w-96 bg-clip-padding">
                                        <div class="flex justify-between p-4 rounded-t-md gap-x-2 bg-zinc-100">
                                            <p class="font-medium text-gray">Notifications</p>
                                            <p class="font-medium cursor-pointer text-primary">Mark as all read</p>
                                        </div>
                                        <ul class="overflow-hidden" style="max-height: 30vh;">
                                            <li data-bs-target="#appointmentSchedule" data-bs-toggle="modal">
                                                <a class="block w-full px-4 py-2 mt-0.5 text-lg font-normal bg-gray-100 dropdown-item whitespace-nowrap hover:bg-blue-100"
                                                   href="#">
                                                    <div class="text-xs font-light text-gray">
                                                        <p>You've a new appointment on <br><span class="font-bold">"12th feb 2022, 11:30 PM"</span>
                                                        </p>
                                                    </div>
                                                </a>
                                            </li>
                                            <li data-bs-target="#appointmentSchedule" data-bs-toggle="modal">
                                                <a class="block w-full px-4 py-2 mt-0.5 text-lg font-normal bg-gray-100 dropdown-item whitespace-nowrap hover:bg-blue-100"
                                                   href="#">
                                                    <div class="text-xs font-light text-primary-dark">
                                                        <p>You've a new appointment on <br><span class="font-bold">"12th feb 2022, 11:30 PM"</span>
                                                        </p>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="relative dropdown">
                                    <div id="dropdownMenuButton1"
                                         aria-expanded="false"
                                         class="flex items-center mr-4 hover: focus: dropdown-toggle hidden-arrow "
                                         data-bs-toggle="dropdown" href="#"
                                         role="button">
                                        <img alt="" class="w-10 h-10 rounded-full shadow-lg" src="/images/profile.jpg">
                                        <i class="p-2 fa-solid text-white fa-angle-down"></i>
                                    </div>
                                    <div
                                        aria-labelledby="dropdownMenuButton1"
                                        class="absolute left-auto z-50 hidden float-left m-0 mt-0 overflow-hidden text-base text-left list-none bg-white border-none rounded-lg shadow-lg -right-20 md:right-0 dropdown-menu min-w-max bg-clip-padding">
                                        <ul class="divide-y border-b">
                                            <li>
                                                <a class="block min-w-[12rem] w-full px-4 py-4 text-lg font-medium bg-white dropdown-item whitespace-nowrap transition-all hover:text-white hover:bg-blue-400"
                                                   href="#">My Profile</a>
                                            </li>
                                            <li>
                                                <a class="block min-w-[12rem] w-full px-4 py-4 text-lg font-medium bg-white dropdown-item whitespace-nowrap transition-all hover:text-white hover:bg-blue-400"
                                                   href="#">Setting</a>
                                            </li>
                                        </ul>
                                        <Link :href="route('admin.logout')" as="button"
                                              class="py-3 min-w-[12rem] font-semibold text-center text-white cursor-pointer bg-blue-500 rounded-md"
                                              method="post"
                                              type="button">
                                            Log Out
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- navbar end -->
        </section>

        <slot>

        </slot>
    </section>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3'

export default {
    name: "AdminLayout",
    components: {
        Link
    },

    mounted() {
        let arrow = document.querySelectorAll(".arrow");
        for (let i = 0; i < arrow.length; i++) {
            arrow[i].addEventListener("click", (e) => {
                let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
                arrowParent.classList.toggle("showMenu");
            });
        }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        sidebarBtn.addEventListener("click", () => {
            sidebar.classList.toggle("close");
        });


    }
}
</script>

<style scoped>

</style>
