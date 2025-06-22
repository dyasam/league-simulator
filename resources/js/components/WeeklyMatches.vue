<template>
    <div class="bg-white shadow-lg rounded-lg overflow-hidden h-full">
        <div class="bg-gradient-to-r from-green-600 to-blue-600 px-4 py-3">
            <h3 class="text-lg font-bold text-white text-center">
                Week {{ week }}
            </h3>
        </div>

        <div class="divide-y divide-gray-200">
            <div
                v-for="match in matchesArray"
                :key="match.id"
                class="p-3 hover:bg-gray-50 transition-colors duration-150"
            >
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center space-x-2 flex-1 min-w-0">
                            <div
                                class="h-6 w-6 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0"
                            >
                                <span class="text-white font-bold text-xs">
                                    {{
                                        match.home_team?.name?.charAt(0) || "?"
                                    }}
                                </span>
                            </div>
                            <span class="font-medium text-gray-900 truncate">{{
                                    match.home_team?.name || "Unknown"
                                }}</span>
                        </div>

                        <div class="px-2 text-center">
                            <div
                                v-if="
                                    match.home_team_score !== null &&
                                    match.away_team_score !== null
                                "
                                class="text-sm font-bold"
                            >
                                <span class="text-blue-600">{{
                                        match.home_team_score
                                    }}</span>
                                <span class="text-gray-400 mx-1">-</span>
                                <span class="text-red-600">{{
                                        match.away_team_score
                                    }}</span>
                            </div>
                            <div v-else class="text-sm text-gray-400">vs</div>
                        </div>

                        <div
                            class="flex items-center space-x-2 flex-1 min-w-0 justify-end"
                        >
                            <span class="font-medium text-gray-900 truncate">{{
                                    match.away_team?.name || "Unknown"
                                }}</span>
                            <div
                                class="h-6 w-6 bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center flex-shrink-0"
                            >
                                <span class="text-white font-bold text-xs">
                                    {{
                                        match.away_team?.name?.charAt(0) || "?"
                                    }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                            :class="
                                match.is_simulated
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-yellow-100 text-yellow-800'
                            "
                        >
                            {{ match.is_simulated ? "Final" : "Scheduled" }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="matchesArray.length === 0" class="p-8 text-center">
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
            <h3 class="mt-2 text-sm font-medium text-gray-900">No matches</h3>
            <p class="mt-1 text-sm text-gray-500">
                No matches scheduled for this week.
            </p>
        </div>
    </div>
</template>

<script>
export default {
    name: "WeeklyMatches",
    props: {
        week: {
            type: [String, Number],
            required: true,
        },
        matches: {
            type: Array,
            default: () => [],
        },
    },
    computed: {
        matchesArray() {
            return this.matches[1] || [];
        },
    },
};
</script>
