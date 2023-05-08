<template>
    <div class="container py-4">
        <TitleComponent />
        <OpenPositionsComponent />
    </div>
</template>

<script>
import OpenPositionsComponent from './components/OpenPositionsComponent.vue';
import TitleComponent from './components/TitleComponent.vue'

export default {
    name: 'App',
    components: {
        OpenPositionsComponent,
        TitleComponent
    }
}
</script>