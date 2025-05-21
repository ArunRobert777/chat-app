<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  message: '',
  room_id: roomId,
  receiver_id: member.user.id,
});

const { roomId, member } = defineProps({
  member: {
    type: Object,
    default: () => null,
  },

  roomId: {
    type: Number,
    default: null,
  },
})

const sendMessage = () => {
  form.message = form.message.trim();
  if (form.message !== '') {
    form.post(route('message.send'), {
      onSuccess: () => {
        form.reset();
      },
      onError: (errors) => {
        console.error(errors);
      },
    });
  }
}
</script>

<template>
  <section class="relative border h-full w-full">
    <header class="absolute top-0 h-[50px] w-full border-b flex items-center px-4">
      <h2>{{ member && member.user ? member.user.name : '' }}</h2>
    </header>
    <footer class="absolute bottom-0 w-full h-[100px] border-t flex items-center px-4">
      <div class="relative flex items-center w-full py-4">
        <form class="relative flex items-center w-full" @submit.prevent="sendMessage">
          <textarea v-model="form.message" rows="2" placeholder="Type your message here..."
            class="absolute rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1 block w-full"></textarea>
          <button type="button" @click="sendMessage" :disabled="form.processing"
            class="absolute right-0 inline-flex items-center rounded-full border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none active:bg-gray-900">Send</button>
        </form>
      </div>
    </footer>
  </section>
</template>