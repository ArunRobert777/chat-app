<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import OnlinePanel from './Partials/OnlinePanel.vue';
import ChatPanel from './Partials/ChatPanel.vue';

defineProps({
  users: {
    type: Array,
    default: () => [],
  },
  selectedChat: {
    type: Object,
    default: () => null,
  },
  room: {
    type: Object,
    default: () => null
  }
})

</script>

<template>

  <Head title="Chat Room" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ room.name }} - Chat Room
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 h-[700px]">
            <section class="h-full">
              <div class="flex flex-col md:flex-row gap-4 h-full">
                <OnlinePanel :members="users" />
                <ChatPanel :member="selectedChat" :roomId="room.id" />
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>