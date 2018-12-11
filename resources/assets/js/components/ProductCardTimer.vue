<template>
    <!--
    Als er meer tijd is dan 24 uur dan geef weer dag:uur
    Wanneer er minder dan 24 uur is dan geef weer uur:minuten
    Wanneer er minder dan 1 uur is dan geef weer minuten:seconden
    Onder 5 minuten is rood
    -->
    <span :class="{ 'text-danger': days < 1 && hours < 1 && minutes < 10 }">{{ timeLeft }}</span>
</template>

<script>
    export default {
        data: () => ({
            now: Date.now(),
            interval: null,
        }),
        computed: {
            diff() {
                return Date.parse(this.end) - this.now;
            },
            days() {
                return Math.floor((this.diff / (1000 * 60 * 60 * 24)) % 365);
            },
            hours() {
                return Math.floor((this.diff / (1000 * 60 * 60)) % 24);
            },
            minutes() {
                return Math.floor((this.diff / (1000 * 60)) % 60);
            },
            seconds() {
                return Math.floor((this.diff / 1000) % 60);
            },
            timeLeft() {
                if (this.days > 0) {
                    return `${this.days}d ${this.hours}u`;
                } else if (this.days < 1 && this.hours > 0) {
                    return `${this.hours}u ${this.minutes}m`;
                } else if (this.diff > 0) {
                    return `${this.minutes}m ${this.seconds}s`;
                } else {
                    return 'Over'
                }
            }
        },
        methods: {
            updateTimer() {
                this.now = Date.now();

                if (this.diff < 0) {
                    clearInterval(this.interval);
                }
            }
        },
        created() {
            this.interval = setInterval(this.updateTimer, 1000);
        },
        beforeDestroy() {
            clearInterval(this.interval);
        },
        props: ['end']
    }
</script>
