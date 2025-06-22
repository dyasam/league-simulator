import "./bootstrap";
import { createApp } from "vue";
import TeamsTable from "./components/TeamsTable.vue";
import SimulationsView from "./components/SimulationsView.vue";
import WeeklyMatches from "./components/WeeklyMatches.vue";

const app = createApp({});
app.component("TeamsTable", TeamsTable);
app.component("SimulationsView", SimulationsView);
app.component("WeeklyMatches", WeeklyMatches);
app.mount("#app");
