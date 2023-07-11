<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div>
        <div
            class="p-6 lg:p-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700"
        >
            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                Welcome to the Quiz Page!
            </h1>

            <p class="mt-6 text-gray-500 dark:text-gray-400 leading-relaxed">
                Here we populate the page with randomly generated questions.
            </p>
        </div>

        <div
            class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8"
        >
            <div>
                <div class="flex items-center">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        class="w-6 h-6 stroke-gray-400"
                    >
                        <path
                            stroke-linecap="round"
                            d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z"
                        />
                    </svg>
                    <h2
                        class="ml-3 text-xl font-semibold text-gray-900 dark:text-white"
                    >
                        <Link :href="route('quiz')">Quiz Page</Link>
                    </h2>
                </div>

                <p
                    class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed"
                >
                    This page is where all the questions are beautifully
                    generated and the learning takes place. Behind the scene
                    algorithms are at work creating skill specific questions for
                    you. This is the power of spritemaths. Every question should
                    be unique so that you are learning to spot patterns and
                    think logically about how to approach a problem instead of
                    memorising the answer to a question.
                </p>
                <button className="border rounded-md">Start Quiz</button>
            </div>
        </div>
    </div>
</template>
