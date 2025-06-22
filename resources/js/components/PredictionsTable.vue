<template>
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">
            Championship Predictions
        </h3>
        <div class="space-y-2">
            <div
                v-for="(prediction, index) in predictions"
                :key="index"
                class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200"
            >
                <div class="flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold"
                    >
                        {{ index + 1 }}
                    </div>
                    <span class="font-medium text-gray-900 text-sm">{{
                            prediction.team.name
                        }}</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm font-medium text-gray-600"
                    >{{ prediction.probability }}%</span
                    >

                    <div class="relative w-8 h-8">
                        <svg
                            class="w-8 h-8 transform -rotate-90"
                            viewBox="0 0 36 36"
                        >
                            <path
                                class="text-gray-300"
                                stroke="currentColor"
                                stroke-width="3"
                                fill="none"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                            />
                            <path
                                :class="
                                    getProgressColor(prediction.probability)
                                "
                                stroke="currentColor"
                                stroke-width="3"
                                fill="none"
                                :stroke-dasharray="`${prediction.probability}, 100`"
                                stroke-linecap="round"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                            />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PredictionsTable",
    props: {
        predictions: {
            type: Array,
            default: () => [],
        },
    },
    setup() {
        const getProgressColor = (prediction) => {
            if (prediction >= 80) return "text-green-500";
            if (prediction >= 60) return "text-blue-500";
            if (prediction >= 40) return "text-yellow-500";
            if (prediction >= 20) return "text-orange-500";
            return "text-red-500";
        };

        return {
            getProgressColor,
        };
    },
};
</script>
