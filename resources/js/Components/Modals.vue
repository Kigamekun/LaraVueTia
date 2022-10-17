<template>
    <div
        class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t"
    >
        <h3 class="text-3xl font-semibold">Update Books</h3>
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
    <form class="w-full max-w-lg" @submit.prevent="submitUpdate">
        <div class="relative p-6 flex-auto">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label
                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-password"
                    >
                        Title
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-password"
                        type="text"
                        v-model="form.title"
                    />
                    <p class="text-gray-600 text-xs italic">
                        Make it as long and as crazy as you'd like
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label
                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-first-name"
                    >
                        Author
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="grid-first-name"
                        type="text"
                        placeholder="Jane"

                        v-model="form.pengarang"
                    />
                    <p class="text-red-500 text-xs italic">
                        Please fill out this field.
                    </p>
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label
                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-last-name"
                    >
                        Publisher
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-last-name"
                        type="text"
                        placeholder="Doe"
                        v-model="form.penerbit"
                    />
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-2">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label
                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-state"
                    >
                        State
                    </label>
                    <div class="relative">
                        <select
                            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-state"
                        >
                            <option>New Mexico</option>
                            <option>Missouri</option>
                            <option>Texas</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                        >
                            <svg
                                class="fill-current h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b"
        >
            <button
                class="text-red-500 bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                type="button"
                v-on:click="this.$emit('updateEvent')"
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
    <!-- {{ title }} -->
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    name: "Modals",
    props: {
        title: String,
        pengarang: String,
        penerbit: String,
    },
    data() {
        return {
            showModal: false,
            showModalUpdate: false,
            modalContent: "",
        };
    },
    setup() {
        const form = useForm({
            title: this.$parent('title'),
            pengarang: this.$parent('pengarang'),
            penerbit: this.$parent('penerbit'),
        });

        return { form };
    },
    methods: {
        destroy(id) {
            this.$inertia.delete(route("books.destroy", id));
        },
        toggleModal: function () {
            this.showModal = !this.showModal;
        },

        submit() {
            this.form.post(route("books.store"));
        },
    },
};
</script>
