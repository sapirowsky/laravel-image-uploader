<script setup>
import vueFilePond, { setOptions } from "vue-filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilepondPluginFileValidateSize from "filepond-plugin-file-validate-size";
import { onMounted, ref } from "vue";
const serverMessage = ref({});
setOptions({
    server: {
        process: {
            url: "./upload",
            onerror: (res) => {
                serverMessage.value = JSON.parse(res);
            },
            headers: {
                "X-CSRF-TOKEN": document.head.querySelector(
                    'meta[name="csrf_token"]'
                ).content,
            },
        },
    },
    labelFileProcessingError: () => {
        return serverMessage.value.error;
    },
});

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilepondPluginFileValidateSize
);

const pond = ref();
const images = ref([]);
const handleProcessedFile = (error, file) => {
    if (error) {
        console.log(error);
        return;
    }
    images.value.unshift(file.serverId);
};
const filepondInitialized = () => {
    console.log("filepond ready", pond);
};

onMounted(() => {
    axios
        .get("/images")
        .then((res) => {
            images.value = res.data;
        })
        .catch((err) => {
            console.log(err);
        });
});
</script>

<template>
    <div>
        <div class="mt-4">
            <file-pond
                name="image"
                ref="pond"
                label-idle="Kliknij lub przeżuć pliki tutaj"
                :allow-multiple="true"
                @init="filepondInitialized"
                accepted-file-types="image/*"
                @processfile="handleProcessedFile"
                maxFileSize="64MB"
            />
        </div>
        <div class="mt-8 mb-24">
            <h3 class="text-2xl font-medium text-center">Galeria zdjęć</h3>
            <div class="grid grid-cols-3 gap-2 justify-evenly mt-4">
                <div v-for="(image, index) in images" :key="index">
                    <img
                        class="w-full h-64 object-cover rounded-xl"
                        :src="'./storage/images/' + image"
                        alt="zdjecie"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
