<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <!-- Sidebar component, swap this element with another sidebar if you like -->
  <div class="flex flex-col h-0 flex-1 bg-gray-800">
    <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
      <inertia-link :href="route('home')" class="flex items-center flex-shrink-0 px-4 text-white">
        <TerminalIcon class="h-5 w-5 mr-2" aria-hidden="true"/>&nbsp;Aaron Brigham
      </inertia-link>
      <nav class="mt-5 flex-1 px-2 bg-gray-800 space-y-1">
        <inertia-link v-for="item in navigation" :key="item.name" :href="item.href"
                      :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']">
          <component :is="item.icon"
                     :class="[item.current ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-300', 'mr-3 h-6 w-6']"
                     aria-hidden="true"/>
          {{ item.name }}
        </inertia-link>
      </nav>
    </div>
  </div>
</template>

<script>
import {
  TerminalIcon,
  FilmIcon,
  PhotographIcon,
} from '@heroicons/vue/outline'


export default {
  data() {
    return {
      navigation: [
        {
          name: 'Movie Review Classifier',
          href: route('home'),
          icon: FilmIcon,
          current: route().current('home')
        },
        {
          name: 'Three.js Demo',
          href: route('three-demo'),
          icon: PhotographIcon,
          current: route().current('three-demo')
        },
      ]
    }
  },
  components: {
    TerminalIcon
  }
}
</script>
