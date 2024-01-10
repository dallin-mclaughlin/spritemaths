<script setup lang="ts">
import functionPlot from "function-plot";
import { ref, onMounted, onUpdated } from "vue";
import { MathfieldElement, renderMathInElement } from "mathlive";
import "../../css/mathlive-fonts.css";
import "../../css/mathlive.css";

const mathFieldAnswer = ref<MathfieldElement>(new MathfieldElement());
mathFieldAnswer.value.mathVirtualKeyboardPolicy = "manual";
const keyboard = window.mathVirtualKeyboard;
keyboard.layouts = ["numeric"];
const index = ref(0);

const props = defineProps({
    blurbs: Array,
    questions: Array,
    submittedAnswers: Array,
    graphdatas: Array<string>,
});

const graphDatas = props.graphdatas.map((element) => {
    return JSON.parse(element);
}) as Array<{ target }>;

const emit = defineEmits(["update:submittedAnswers", "submit"]);

onMounted(() => {
    renderMathInElement("mathFieldQuestion");
    if (props.blurbs[0] != null) renderMathInElement("mathFieldBlurb");
    if (props.graphdatas[0] != null) functionPlot(graphDatas[0]);
    mathFieldAnswer.value.focus();
    if (props.submittedAnswers[0] == null) {
        mathFieldAnswer.value.insert("");
    } else {
        mathFieldAnswer.value.insert(String(props.submittedAnswers[0]));
    }
    keyboard.hide();
});

onUpdated(() => {
    renderMathInElement("mathFieldQuestion");
    if (props.blurbs[index.value] != null)
        renderMathInElement("mathFieldBlurb");
    if (props.graphdatas[index.value] != null)
        functionPlot(graphDatas[index.value]);
    let toggle = keyboard.visible;
    mathFieldAnswer.value.focus();
    if (!toggle) {
        keyboard.hide();
    }
});

function handlePrevious() {
    if (props.questions != undefined && index.value != 0) {
        updateAnswers();
        index.value =
            (index.value + props.questions.length - 1) % props.questions.length;
    }
}

function handleNext() {
    if (
        props.questions != undefined &&
        index.value != props.questions.length - 1
    ) {
        updateAnswers();
        index.value = (index.value + 1) % props.questions.length;
    }
}

function save(route) {
    emit("submit", route);
}

function updateAnswers() {
    emit("update:submittedAnswers", mathFieldAnswer.value.value, index.value);
}
</script>

<template>
    <div>
        <div
            class="p-6 lg:p-8 text-center bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700"
        >
            <div className="flex justify-between">
                <form @submit.prevent="save('quiz.save')">
                    <button
                        @click="updateAnswers"
                        type="submit"
                        className="text-gray-500 dark:text-gray-400 bg-slate-200 border-2 rounded-md px-4"
                    >
                        Save
                    </button>
                </form>
                <form @submit.prevent="save('quiz.results')">
                    <button
                        @click="updateAnswers"
                        type="submit"
                        className="text-gray-500 dark:text-gray-400 bg-slate-200 border-2 rounded-md px-4"
                    >
                        Mark
                    </button>
                </form>
            </div>
            <div
                v-show="graphDatas[index].hasOwnProperty('target')"
                class="flex justify-center"
                id="root"
            ></div>
            <p>Question {{ index + 1 }}/{{ props.questions.length }}</p>
            <p
                v-if="props.blurbs[index]"
                id="mathFieldBlurb"
                class="mt-8 text-lg font-medium text-gray-900 dark:text-white font-['KaTeX_Fraktur']"
            >
                {{ props.blurbs[index] }}
            </p>
            <p
                id="mathFieldQuestion"
                class="mt-8 text-3xl font-medium text-gray-900 dark:text-white font-['KaTeX_Fraktur']"
            >
                {{ props.questions[index] }}
            </p>
        </div>

        <div
            class="bg-gray-200 dark:bg-gray-800 bg-opacity-25 grid grid-cols-1 gap-6 lg:gap-8 p-6 lg:p-8 text-center"
        >
            <!-- // include the answer part here -->
            <math-field
                ref="mathFieldAnswer"
                className="text-3xl justify-center"
                plonkSound="none"
                :value="submittedAnswers[index]"
            ></math-field>
            <div className="flex justify-between">
                <button
                    :disabled="index == 0"
                    @click="handlePrevious"
                    className="text-gray-500 disabled:text-gray-300 dark:text-gray-400 bg-slate-200 disabled:bg-transparent border-2 rounded-md px-4"
                >
                    Previous
                </button>
                <button
                    :disabled="index == props.questions.length - 1"
                    @click="handleNext"
                    className="text-gray-500 disabled:text-gray-300 dark:text-gray-400 bg-slate-200 disabled:bg-transparent border-2 rounded-md px-4"
                >
                    Next
                </button>
            </div>
        </div>
    </div>
</template>
