<template>
    <!--
    Als er meer tijd is dan 24 uur dan geef weer dag:uur
    Wanneer er minder dan 24 uur is dan geef weer uur:minuten
    Wanneer er minder dan 1 uur is dan geef weer minuten:seconden
    Onder 5 minuten is rood
    -->
    <span :class="{ 'text-danger': isToday && hours < 1 && minutes < 10 }">
        {{ timeLeft }}
    </span>
</template>

<script>
    import * as moment from "moment";

    export default {
        data: () => ({
            now: moment().unix() * 1000,
            interval: null,
        }),
        computed: {
            test() {
                return moment(this.end).unix()
            },
            diff() {
                return (moment(this.end).unix() * 1000) - this.now;
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
                if (this.diff > 0) {
                    return 'nog ' + moment.duration(this.diff).humanize();
                } else {
                    return 'Veiling afgelopen'
                }
            },
            isToday() {
                return this.days < 1;
            }
        },
        methods: {
            updateTimer() {
                this.now = moment().unix() * 1000;

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
