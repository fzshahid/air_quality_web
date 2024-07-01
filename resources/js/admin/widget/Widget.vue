<script>
export default {
    props: {
        initialData: {
            type: Object,
            required: true
        }
    },
    template: `
        <div class="widget">
        <h2>Air Quality Measurement</h2>
        <div class="measurement">
            <label>Humidity:</label>
            <span>{{ data.humidity }} %</span>
        </div>
        <div class="measurement">
            <label>Temperature:</label>
            <span>{{ data.temperature }} °C</span>
        </div>
        <div class="measurement">
            <label>PM1.5:</label>
            <span>{{ data.pm1_5 }} µg/m³</span>
        </div>
        <div class="measurement">
            <label>PM10:</label>
            <span>{{ data.pm10 }} µg/m³</span>
        </div>
        <div class="measurement">
            <label>TVOC:</label>
            <span>{{ data.tvoc }} ppb</span>
        </div>
        <div class="measurement">
            <label>CO₂:</label>
            <span>{{ data.co2 }} ppm</span>
        </div>
        <div class="advisory" v-if="data.humidity > 60">
            High humidity levels detected. Consider using a dehumidifier.
        </div>
        <div class="advisory" v-if="data.co2 > 1000">
            High CO₂ levels detected. Ensure good ventilation.
        </div>
        <div class="subscribe">
            <button @click="subscribe">Subscribe to Notifications</button>
        </div>
    </div>
    `,
    data() {
        return {
            data: this.initialData
        };
    },
    methods: {
        subscribe() {
            // Handle subscription logic
            alert("Subscribed to notifications!");
        }
    }
};
</script>

<style scoped>
/* Styles for the Vue component */
</style>
