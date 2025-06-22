<template>
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Football Teams</h2>
        </div>

        <div v-if="loading" class="flex justify-center items-center py-12">
            <div
                class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"
            ></div>
            <span class="ml-3 text-gray-600">Loading teams...</span>
        </div>

        <div
            v-else-if="error"
            class="bg-red-50 border border-red-200 rounded-lg m-6 p-4"
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
                    <h3 class="text-sm font-medium text-red-800">
                        Error loading teams
                    </h3>
                    <p class="text-sm text-red-700 mt-1">{{ error }}</p>
                </div>
            </div>
        </div>

        <div v-else-if="teams.length > 0" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Team Name
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Power
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Home Advantage
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Supporter Strength
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Attack Power
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Defense Power
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr
                    v-for="team in teams"
                    :key="team.name"
                    class="hover:bg-gray-50 transition-colors duration-150"
                >
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div
                                    class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center"
                                >
                                        <span
                                            class="text-white font-bold text-sm"
                                        >{{ team.name.charAt(0) }}</span
                                        >
                                </div>
                            </div>
                            <div class="ml-4">
                                <div
                                    class="text-sm font-medium text-gray-900"
                                >
                                    {{ team.name }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-16 bg-gray-200 rounded-full h-2"
                                >
                                    <div
                                        class="bg-blue-600 h-2 rounded-full"
                                        :style="{
                                                width:
                                                    (team.power / 100) * 100 +
                                                    '%',
                                            }"
                                    ></div>
                                </div>
                            </div>
                            <span class="ml-2 text-sm text-gray-900">{{
                                    team.power
                                }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                :class="
                                    team.home_advantage >= 50
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-yellow-100 text-yellow-800'
                                "
                            >
                                {{ team.home_advantage }}
                            </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                :class="
                                    team.supporter_strength >= 50
                                        ? 'bg-purple-100 text-purple-800'
                                        : 'bg-gray-100 text-gray-800'
                                "
                            >
                                {{ team.supporter_strength }}
                            </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-16 bg-gray-200 rounded-full h-2"
                                >
                                    <div
                                        class="bg-red-500 h-2 rounded-full"
                                        :style="{
                                                width:
                                                    (team.attack_power / 100) *
                                                        100 +
                                                    '%',
                                            }"
                                    ></div>
                                </div>
                            </div>
                            <span class="ml-2 text-sm text-gray-900">{{
                                    team.attack_power
                                }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-16 bg-gray-200 rounded-full h-2"
                                >
                                    <div
                                        class="bg-green-500 h-2 rounded-full"
                                        :style="{
                                                width:
                                                    (team.defense_power / 100) *
                                                        100 +
                                                    '%',
                                            }"
                                    ></div>
                                </div>
                            </div>
                            <span class="ml-2 text-sm text-gray-900">{{
                                    team.defense_power
                                }}</span>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div v-else class="text-center py-12">
            <svg
                class="mx-auto h-12 w-12 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">
                No teams found
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                No football teams are currently available.
            </p>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";

export default {
    name: "TeamsTable",
    setup() {
        const teams = ref([]);
        const loading = ref(false);
        const error = ref(null);

        const fetchTeams = async () => {
            loading.value = true;
            error.value = null;

            try {
                const response = await fetch("/api/teams", {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.status && data.data) {
                    teams.value = data.data;
                } else if (data.success && data.data) {
                    teams.value = data.data;
                } else if (Array.isArray(data)) {
                    teams.value = data;
                } else {
                    throw new Error("Unexpected response format");
                }
            } catch (err) {
                error.value = err.message || "Failed to fetch teams";
                console.error("Error fetching teams:", err);
            } finally {
                loading.value = false;
            }
        };

        onMounted(() => {
            fetchTeams();
        });

        return {
            teams,
            loading,
            error,
            fetchTeams,
        };
    },
};
</script>
