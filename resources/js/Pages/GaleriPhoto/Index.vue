<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import Gallery from '@/Components/Gallery.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import TextArea from '@/Components/TextArea.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectOption from '@/Components/SelectOption.vue';

// const props = defineProps(['galeriPhoto']);

defineProps(['chirps', 'galeriPhoto']);

const form = useForm({
    title: '',
    category: '',
    description: '',
    images: [],
});


const categories = [
    { value: 'education', label: 'Pendidikan' },
    { value: 'food', label: 'Makanan' },
    { value: 'travelling', label: 'Travelling' },
    { value: 'general', label: 'Umum' },
];


const handleFileUpload = (event) => {
  const files = event.target.files;
  form.images = Array.from(files); // Convert FileList to Array and update form data
};
const submit = () => {
    form.post(route('galeri-photo.store'), {
        onFinish: () => form.reset('title', 'category', 'description', 'images'),
    });
};
</script>

<template>
    <Head title="Gallery" />

    <AuthenticatedLayout>
        <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
            <div class="relative p-4 w-full max-w max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <form
                        @submit.prevent="submit"
                        class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <InputLabel for="title" value="Judul Album" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    autofocus
                                    autocomplete="username"
                                    placeholder="Type album name"
                                />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>
                            <div class="col-span-2 mb-2 sm:col-span-1">
                                <InputLabel for="title" value="Gambar" />

                                <input
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                                    id="multiple_files"
                                    type="file"
                                    @change="handleFileUpload"
                                    multiple>

                                <InputError class="mt-2" :message="form.errors.images" />
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <InputLabel for="title" value="Pilih Kategori Album" />
                                <SelectOption
                                    id="category" class="bg-gray-50 mt-1 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                    :categories="categories"
                                    v-model="form.category" />
                                <InputError class="mt-2" :message="form.errors.category" />
                            </div>
                            <div class="col-span-2">
                                <InputLabel for="description" value="Keterangan" />
                                <TextArea
                                    id="description"
                                    type="text"

                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-500"
                                    v-model="form.description"
                                    rows="4"
                                    autofocus
                                    autocomplete="username"
                                    placeholder="Write album description here"
                                ></TextArea>
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>
                        </div>
                        <PrimaryButton class="ms-4 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            Album
                        </PrimaryButton>
                    </form>

                    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                        <Gallery />
                    </div>
                </div>
            </div>
        </div>


    </AuthenticatedLayout>
</template>
