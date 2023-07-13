<script setup lang="ts">
import { ref, onMounted, onUpdated } from "vue";
import { MathfieldElement, renderMathInElement } from "mathlive";
import { Link } from "@inertiajs/vue3";
import "../../css/mathlive-fonts.css";
import "../../css/mathlive.css";

const mathFieldAnswer = ref<MathfieldElement>();
const keyboard = window.mathVirtualKeyboard;
console.log(window);
//keyboard.layouts = ["numeric", "symbols"];
</script>

<template>
    <div>
        <div
            class="p-6 lg:p-8 text-center bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700"
        >
            <h1 class="mt-8 text-2xl font-medium text-gray-900 dark:text-white">
                The Question
            </h1>
        </div>

        <div
            class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8"
        >
            <!-- // include the answer part here -->
            <math-field
                :ref="mathFieldAnswer"
                plonkSound="none"
                className="border-2 w-96 shadow-xl"
                mathVirtualKeyboardPolicy="auto"
                value="2x+3"
            ></math-field>
            <div>
                <div>
                    <button
                        className="text-gray-500 dark:text-gray-400 border rounded-md"
                    >
                        Previous Question
                    </button>
                    <button
                        className="text-gray-500 dark:text-gray-400 border rounded-md"
                    >
                        Next Question
                    </button>
                </div>
                <div>
                    <button
                        className="text-gray-500 dark:text-gray-400 border rounded-md"
                    >
                        Save and Exit
                    </button>
                    <button
                        className="text-gray-500 dark:text-gray-400 border rounded-md"
                    >
                        Save and Mark
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
