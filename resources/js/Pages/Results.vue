<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Results from "@/Components/Results.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    Quiz: Object,
});

const submit = () => {
    useForm({
        id: props.Quiz.id,
    }).post(route("quiz.delete"));
};
</script>

<template>
    <AppLayout title="Results">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Results
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg"
                >
                    <Results
                        :questionanswers="props.Quiz.questionanswers"
                        @submit="submit"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
