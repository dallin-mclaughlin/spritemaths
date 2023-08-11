<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Quiz from "@/Components/Quiz.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    ID: Number,
    Questions: Array,
    SubmittedAnswers: Array,
});

const submittedAnswers = props.SubmittedAnswers;

function onUpdate(answer, index) {
    submittedAnswers[index] = answer;
}

const submit = () => {
    useForm({
        id: props.ID,
        submittedanswers: submittedAnswers,
    }).post(route("quiz.save"));
};
</script>

<template>
    <AppLayout title="Quiz">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Quiz
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg"
                >
                    <Quiz
                        @update:submittedAnswers="onUpdate"
                        @submit="submit"
                        :questions="props.Questions"
                        :submittedAnswers="submittedAnswers"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
