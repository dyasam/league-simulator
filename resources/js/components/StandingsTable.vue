<template>
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4">League Standings</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Position
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Team
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Played
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Won
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Drawn
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Lost
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        GF
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        GA
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        GD
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    >
                        Points
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr
                    v-for="(team, index) in sortedStandings"
                    :key="team.team_id"
                    :class="getRowClass(index)"
                >
                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                    >
                        {{ index + 1 }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            {{ team.team.name }}
                        </div>
                    </td>
                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                        {{ team.played }}
                    </td>
                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                        {{ team.wins }}
                    </td>
                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                        {{ team.draws }}
                    </td>
                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                        {{ team.losses }}
                    </td>
                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                        {{ team.goals_for }}
                    </td>
                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                        {{ team.goals_against }}
                    </td>
                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                            <span
                                :class="
                                    getGoalDifferenceClass(team.goal_difference)
                                "
                            >
                                {{ team.goal_difference > 0 ? "+" : ""
                                }}{{ team.goal_difference }}
                            </span>
                    </td>
                    <td
                        class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900"
                    >
                        {{ team.points }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { computed } from "vue";

export default {
    name: "StandingsTable",
    props: {
        standings: {
            type: Array,
            default: () => [],
        },
    },
    setup(props) {
        const sortedStandings = computed(() => {
            if (!props.standings || !Array.isArray(props.standings)) {
                return [];
            }

            return props.standings;
        });

        const getRowClass = (index) => {
            if (index === 0) {
                return "bg-green-50 border-l-4 border-green-400";
            }

            return "hover:bg-gray-50";
        };

        const getGoalDifferenceClass = (goalDifference) => {
            if (goalDifference > 0) {
                return "text-green-600 font-medium";
            } else if (goalDifference < 0) {
                return "text-red-600 font-medium";
            }
            return "text-gray-500";
        };

        return {
            sortedStandings,
            getRowClass,
            getGoalDifferenceClass,
        };
    },
};
</script>
