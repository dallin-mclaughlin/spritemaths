<script setup lang="ts">
import { ref, onMounted, onUpdated } from "vue";
import { renderMathInDocument, renderMathInElement } from "mathlive";
import { Link } from "@inertiajs/vue3";

interface QuestionAnswer {
    question: string;
    submitted_answer: string;
    correct_answer: string;
    is_correct: boolean;
}

const props = defineProps({
    questionanswers: Array<QuestionAnswer>,
});

const emit = defineEmits(["submit"]);

onMounted(() => {
    renderMathInDocument();
});
</script>

<template>
    <div>
        <div
            class="p-6 lg:p-8 text-center bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700"
        >
            <div className="flex justify-between">
                <form @submit.prevent="emit('submit')">
                    <button
                        type="submit"
                        className="text-gray-500 dark:text-gray-400 bg-slate-200 border-2 rounded-md px-4"
                    >
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div
            class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 gap-6 lg:gap-8 p-6 lg:p-8 text-center"
        >
            <div v-for="questionanswer in questionanswers">
                <p>
                    {{ questionanswer.question }}
                </p>
                <p
                    v-if="
                        questionanswer.submitted_answer == '' ||
                        questionanswer.submitted_answer == null
                    "
                >
                    You did not provide an answer for this question. The correct
                    answer is
                    {{ "\\(" + questionanswer.correct_answer + "\\)" }}
                </p>
                <p v-else-if="questionanswer.is_correct">
                    Your answer
                    {{ "\\(" + questionanswer.submitted_answer + "\\)" }} is
                    correct!
                </p>
                <p v-else>
                    Your answer
                    {{ "\\(" + questionanswer.submitted_answer + "\\)" }} is
                    incorrect. The correct answer is
                    {{ "\\(" + questionanswer.correct_answer + "\\)" }}
                </p>
            </div>
        </div>
    </div>
</template>
