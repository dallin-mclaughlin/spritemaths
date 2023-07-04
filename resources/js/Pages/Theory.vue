<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Theory from "@/Components/Theory.vue";
</script>

<template>
    <AppLayout title="Theory">
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Theory
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg"
                >
                    <Theory />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
