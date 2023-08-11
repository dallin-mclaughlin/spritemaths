<script setup>
import { Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    questions: Array,
    quizs: Array,
});

const form = useForm({
    id: 0,
    newquiz: true,
});

const submit = () => {
    form.post(route("quiz"));
};
</script>

<template>
    <div>
        <div
            class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700"
        >
            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                Saved Quizzes
            </h1>
            <form @submit.prevent="submit">
                <div
                    class="bg-opacity-25 grid grid-cols-5 gap-6 lg:gap-8 p-6 lg:p-8"
                >
                    <div
                        v-for="quiz in quizs"
                        class="hover:bg-gray-100 rounded-lg"
                    >
                        <button
                            type="submit"
                            @click="
                                () => {
                                    form.id = quiz.id;
                                    form.newquiz = false;
                                }
                            "
                            :disabled="form.processing"
                        >
                            {{ quiz.title }} {{ quiz.percentage_complete }}
                            {{ quiz.updated_at }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <form @submit.prevent="submit">
            <div
                class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-5 gap-6 lg:gap-8 p-6 lg:p-8"
            >
                <div v-for="question in questions">
                    <button
                        type="submit"
                        @click="
                            () => {
                                form.id = question.id;
                                form.newquiz = true;
                            }
                        "
                        :disabled="form.processing"
                    >
                        {{ question.title }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
