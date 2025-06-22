<template>
    <div>
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <div class="flex items-center justify-end gap-4">
                <button
                    @click="createSimulation"
                    :disabled="loading"
                    class="bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 disabled:from-gray-400 disabled:to-gray-500 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-105 disabled:hover:scale-100 disabled:cursor-not-allowed cursor-pointer"
                >
                    <svg
                        v-if="loading"
                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                    </svg>
                    {{ loading ? "Regenerating..." : "Regenerate" }}
                </button>
                <button
                    @click="playAll"
                    :disabled="loading || isAllWeeksPlayed"
                    class="bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 disabled:from-gray-400 disabled:to-gray-500 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-105 disabled:hover:scale-100 disabled:cursor-not-allowed cursor-pointer"
                >
                    <svg
                        v-if="loading"
                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                    </svg>
                    {{ loading ? "Playing..." : "Play All" }}
                </button>
                <button
                    @click="playNextWeek"
                    :disabled="loading || isAllWeeksPlayed"
                    class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 disabled:from-gray-400 disabled:to-gray-500 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform transition-all duration-200 hover:scale-105 disabled:hover:scale-100 disabled:cursor-not-allowed cursor-pointer"
                >
                    <svg
                        v-if="loading"
                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                    </svg>
                    {{ loading ? "Playing..." : "Play Next Week" }}
                </button>
            </div>
        </div>

        <div
            v-if="simulationLoading"
            class="flex justify-center items-center py-12"
        >
            <div
                class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"
            ></div>
            <span class="ml-3 text-gray-600">Loading simulation...</span>
        </div>

        <div
            v-else-if="error"
            class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6"
        >
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg
                        class="h-5 w-5 text-red-400"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Error</h3>
                    <p class="text-sm text-red-700 mt-1">{{ error }}</p>
                </div>
            </div>
        </div>

        <div v-else-if="currentSimulation && weeklyGames.length > 0">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Current Simulation
                </h2>
                <p class="text-gray-600">
                    Simulation ID:
                    <span
                        class="font-mono text-sm bg-gray-100 px-2 py-1 rounded"
                    >{{ currentSimulation.uid }}</span
                    >
                </p>
            </div>

            <div class="grid grid-cols-12 gap-8 mb-8">
                <div
                    :class="predictions ? 'col-span-8' : 'col-span-12'"
                    class="space-y-6"
                >
                    <standings-table
                        :standings="currentSimulation.standings || []"
                    />
                </div>
                <div class="col-span-4 space-y-6" v-if="predictions">
                    <predictions-table :predictions="predictions" />
                </div>
            </div>

            <div class="grid grid-cols-12 gap-8">
                <div class="col-span-12 space-y-6">
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">
                            Weekly Matches
                        </h3>
                        <div class="grid grid-cols-3 gap-4">
                            <weekly-games
                                v-for="(games, week) in weeklyGames"
                                :key="week + 1"
                                :week="week + 1"
                                :games="games"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="text-center py-12">
            <svg
                class="mx-auto h-16 w-16 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">
                No Simulation Active
            </h3>
            <p class="mt-2 text-gray-500">
                Create a new simulation to see the weekly matches and results.
            </p>
        </div>
    </div>
</template>

<script>
import { ref, computed } from "vue";
import WeeklyGames from "./WeeklyGames.vue";
import StandingsTable from "./StandingsTable.vue";
import PredictionsTable from "./PredictionsTable.vue";

export default {
    name: "SimulationsView",
    components: {
        WeeklyGames,
        StandingsTable,
        PredictionsTable,
    },
    mounted() {
        this.createSimulation();
    },
    setup() {
        const currentSimulation = ref(null);
        const loading = ref(false);
        const simulationLoading = ref(false);
        const error = ref(null);
        const weekCount = ref(0);

        const predictions = computed(() => {
            return currentSimulation.value?.predictions || null;
        });

        const weeklyGames = computed(() => {
            if (!currentSimulation.value || !currentSimulation.value.games) {
                return [];
            }

            const result = Object.entries(currentSimulation.value.games).sort(
                (a, b) => {
                    return parseInt(a[0]) - parseInt(b[0]);
                }
            );

            return result;
        });

        const isAllWeeksPlayed = computed(() => {
            if (!currentSimulation.value || !currentSimulation.value.games) {
                return false;
            }
            const totalWeeks = Object.keys(
                currentSimulation.value.games
            ).length;
            return weekCount.value >= totalWeeks;
        });

        const handleApiError = (err, defaultMessage) => {
            if (err.response) {
                error.value = `HTTP error! status: ${err.response.status}`;
            } else if (err.request) {
                error.value = "Network error - no response received";
            } else {
                error.value = err.message || defaultMessage;
            }
            console.error(`API Error: ${defaultMessage}`, err);
        };

        const processApiResponse = (data) => {
            if (data.message === "success" && data?.data?.games) {
                const { uid, games, standings, predictions } = data.data;
                currentSimulation.value = {
                    uid,
                    games,
                    standings,
                    predictions,
                };

                return true;
            } else {
                throw new Error("Unexpected response format");
            }
        };

        const makeApiRequest = async (url, errorMessage) => {
            loading.value = true;
            error.value = null;

            try {
                const response = await axios.post(
                    url,
                    {},
                    {
                        headers: {
                            "Content-Type": "application/json",
                            Accept: "application/json",
                        },
                    }
                );

                processApiResponse(response.data);
            } catch (err) {
                handleApiError(err, errorMessage);
            } finally {
                loading.value = false;
            }
        };

        const createSimulation = async () => {
            weekCount.value = 0;
            await makeApiRequest(
                "/api/simulations",
                "Failed to create simulation"
            );
        };

        const playAll = async () => {
            await makeApiRequest(
                `/api/simulations/${currentSimulation.value.uid}/play-all`,
                "Failed to play all"
            );

            weekCount.value = Object.keys(currentSimulation.value.games).length;
        };

        const playNextWeek = async () => {
            await makeApiRequest(
                `/api/simulations/${currentSimulation.value.uid}/play-next-week`,
                "Failed to play next week"
            );
            weekCount.value++;
        };

        return {
            currentSimulation,
            loading,
            simulationLoading,
            error,
            weekCount,
            predictions,
            weeklyGames,
            isAllWeeksPlayed,
            createSimulation,
            playAll,
            playNextWeek,
        };
    },
};
</script>
