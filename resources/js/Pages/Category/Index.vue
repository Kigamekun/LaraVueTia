<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Category
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <br />
                    <br />
                    <div class="flex justify-end mr-5">
                        <button
                            class="bg-pink-500 text-white active:bg-pink-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button"
                            v-on:click="toggleModal()"
                        >
                            Create
                        </button>
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table style="width: 100%">
                            <thead class="font-bold bg-gray-300 border-b-2">
                                <td class="px-4 py-2">No</td>
                                <td class="px-4 py-2">Name</td>

                                <td class="px-4 py-2" style="width:300px;">Action</td>
                            </thead>
                            <tbody>
                                <tr v-for="(category, index) in categories.data" :key="category.id">
                                    <td class="px-4 py-2">{{ index + 1 }}</td>
                                    <td class="px-4 py-2">{{ category.name }}</td>

                                    <td class="px-4 py-2 font-extrabold">
                                        <button
                                            class="bg-orange-500 text-white active:bg-orange-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="button" :data-id="category.id" :data-name="category.name"
                                            v-on:click="toggleModalUpdateData($event)"
                                        >
                                            Update
                                        </button>
                                        <Link
                                            @click="destroy(category.id)"
                                            class="bg-red-500 text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                            >Delete</Link
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination :links="categories.links" />
                    </div>
                </div>
            </div>
        </div>

        <div
            v-if="showModalUpdate"
            class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex"
        >
            <div class="relative w-auto my-6 mx-auto max-w-6xl">
                <!--content-->
                <div  class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                <Modals @updateEvent='toggleModalUpdate' :id="modalUpdateData.id" :name="modalUpdateData.name">

                </Modals>
                </div>
            </div>
        </div>
        <div
            v-if="showModalUpdate"
            class="opacity-25 fixed inset-0 z-40 bg-black"></div>
        <div>
            <div
                v-if="showModal"
                class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
                <div class="relative w-auto my-6 mx-auto max-w-6xl">
                    <!--content-->
                    <div
                        class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                        <!--header-->
                        <div
                            class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t"
                        >
                            <h3 class="text-3xl font-semibold">Create Books</h3>
                            <button
                                class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                                v-on:click="toggleModal()"
                            >
                                <span
                                    class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none"
                                >
                                    ×
                                </span>
                            </button>
                        </div>
                        <!--body-->
                        <form class="w-full max-w-lg" @submit.prevent="submit">
                            <div class="relative p-6 flex-auto">
                                <div class="flex flex-wrap -mx-3 mb-6">
                                    <div class="w-full px-3">
                                        <label
                                            class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                            for="grid-name" required
                                        >
                                            Title
                                        </label>
                                        <input
                                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                            id="grid-name"
                                            type="text"
                                            v-model="form.name"
                                        />
                                    </div>
                                </div>
                            </div>
                            <!--footer-->
                            <div
                                class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b"
                            >
                                <button
                                    class="text-red-500 bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                    type="button"
                                    v-on:click="toggleModal()"
                                >
                                    Close
                                </button>
                                <button
                                    class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                    type="submit"
                                >
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import Modals from '@/Components/ModalUpdateCategory.vue';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        BreezeNavLink,
        Link,
        Modals
    },
    props: {
        categories: Object,
    },
    data() {
        return {
            showModal: false,
            showModalUpdate: false,
            modalUpdateData: {
                id: null,
                name: null,
            },
        };
    },
    setup() {
        const form = useForm({
            name: null,
        });

        return { form };
    },
    methods: {
        destroy(id) {
            this.$inertia.delete(route("categories.destroy", id));
        },
        toggleModal: function () {
            this.showModal = !this.showModal;
        },
        toggleModalUpdate: function () {
            this.showModalUpdate = !this.showModalUpdate;
        },
        toggleModalUpdateData: function (e) {

            this.modalUpdateData.id = e.currentTarget.getAttribute('data-id');
            this.modalUpdateData.name = e.currentTarget.getAttribute('data-name');
            this.showModalUpdate = !this.showModalUpdate;
        },
        submit() {
            this.form.post(route("categories.store"));
        },
    },
};
</script>
