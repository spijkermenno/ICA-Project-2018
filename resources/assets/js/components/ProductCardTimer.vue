<template>
    <!--
    Als er meer tijd is dan 24 uur dan geef weer dag:uur
    Wanneer er minder dan 24 uur is dan geef weer uur:minuten
    Wanneer er minder dan 1 uur is dan geef weer minuten:seconden
    Onder 5 minuten is rood
    -->
    <span :class="cssClasses">
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
            diff() {
                return (moment(this.end).unix() * 1000) - this.now;
            },
            timeLeft() {
                if (this.diff < 0) {
                    return 'Veiling afgelopen';
                }

                const duration = moment.duration(this.diff);

                const totalHoursLeft = duration.asHours();
                const totalDaysLeft = duration.asDays();

                const hoursLeft = duration.hours();
                const minutesLeft = duration.minutes();
                const secondsLeft = duration.seconds();


                if (totalHoursLeft > 24) {
                    return `${Math.floor(totalDaysLeft)}d ${hoursLeft}u`;
                } else if (totalHoursLeft < 24 && totalHoursLeft > 1) {
                    return `${hoursLeft}u ${minutesLeft}m`;
                }

                return `${minutesLeft}m ${secondsLeft}s`;
            },
            cssClasses() {
                const duration = moment.duration(this.diff);

                return {
                    'text-danger': duration.asMinutes() < 5
                }
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
