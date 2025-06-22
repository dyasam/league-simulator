import "./bootstrap";
import { createApp } from "vue";
import TeamsTable from "./components/TeamsTable.vue";
import SimulationsView from "./components/SimulationsView.vue";
import WeeklyGames from "./components/WeeklyGames.vue";

const app = createApp({});
app.component("TeamsTable", TeamsTable);
app.component("SimulationsView", SimulationsView);
app.component("WeeklyGames", WeeklyGames);
app.mount("#app");
