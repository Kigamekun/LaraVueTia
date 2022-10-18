<template>
    <div
        class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t"
    >
        <h3 class="text-3xl font-semibold">Update Category</h3>
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
    <form class="w-full max-w-lg" @submit.prevent="submit">
        <div class="relative p-6 flex-auto">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label
                        class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-password"
                    >
                        Name
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-password"
                        type="text"
                        v-model="form.name"
                    />
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
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    name: "Modals",
    props: {
        id: String,
        name: String,
    },
    data() {
        return {
            showModal: false,
            showModalUpdate: false,
            modalContent: "",
            form: {
                id: this.id,
                name: this.name,
            },
        };
    },
    methods: {
        submit() {
            const form = useForm(this.form);
            form.put(route("categories.update", this.id));
        },
    },
};
</script>
