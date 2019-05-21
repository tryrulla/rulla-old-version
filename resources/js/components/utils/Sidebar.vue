<template>
  <div class="flex-none w-full md:max-w-xs text-black bg-gray-300">
    <div class="px-4 h-16 bg-gray-400 text-xl font-mono flex items-center justify-between">
      <router-link :to="{ name: 'home' }">
        Rulla
      </router-link>

      <button
        class="md:hidden"
        @click="open = !open"
      >
        <i :class="open ? ['fas', 'fa-times'] : ['fas', 'fa-bars']" />
      </button>
    </div>

    <div :class="open ? [] : ['hidden', 'md:block']">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      open: false,
    };
  },
};
</script>
