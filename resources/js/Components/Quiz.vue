<script setup lang="ts">
import { ref, onMounted, onUpdated } from "vue";
import { MathfieldElement } from "mathlive";
import { Link } from "@inertiajs/vue3";
import "../../css/mathlive-fonts.css";
import "../../css/mathlive.css";

const mathFieldAnswer = ref<MathfieldElement>(new MathfieldElement());
const keyboard = window.mathVirtualKeyboard;
keyboard.layouts = ["numeric"];
</script>

<template>
    <div>
        <div
            class="p-6 lg:p-8 text-center bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700"
        >
            <div className="flex justify-between">
                <button
                    className="text-gray-500 dark:text-gray-400 border-2 rounded-md px-4"
                >
                    Save and Exit
                </button>
                <button
                    className="text-gray-500 dark:text-gray-400 border-2 rounded-md px-4"
                >
                    Save and Mark
                </button>
            </div>
            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                The Question
            </h1>
        </div>

        <div
            class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 gap-6 lg:gap-8 p-6 lg:p-8 text-center"
        >
            <!-- // include the answer part here -->
            <math-field
                ref="mathFieldAnswer"
                className="text-3xl justify-center"
                plonkSound="none"
                value="2+3"
            ></math-field>
            <div className="flex justify-between">
                <button
                    className="text-gray-500 dark:text-gray-400 border-2 dark:border-red-100 rounded-md px-4"
                >
                    Previous Question
                </button>
                <button
                    className="text-gray-500 dark:text-gray-400 border-2 rounded-md px-4"
                >
                    Next Question
                </button>
            </div>
        </div>
    </div>
</template>
