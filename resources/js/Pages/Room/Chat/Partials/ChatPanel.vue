<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import Echo from 'laravel-echo';
import { nextTick, ref } from 'vue';

const props = defineProps({
  member: {
    type: Object,
    default: () => null,
  },

  room: {
    type: Object,
    default: () => null,
  },

  messages: {
    type: Array,
    default: () => [],
  },
})

const scrollAnchor = ref(null);

const form = useForm({
  message: '',
  room_id: props.room.id,
  receiver_id: null,
});

const sendMessage = () => {
  form.message = form.message.trim();
  if (form.message !== '') {
    form.receiver_id = props.member ? props.member.user_id : null;
    axios.post(route('message.send'), form)
      .then(res => {
        props.messages.push(res.data.message);
        form.reset();

        nextTick(() => {
          scrollToBottom();
        });
      })
      .catch(err => {
        console.log(err);
      })
  }
}

window.Echo.private(`chat.user.${usePage().props.auth.user.id}`)
  .listen('MessageSent', (e) => {
    props.messages.push(e.message);
    nextTick(() => {
      scrollToBottom();
    });
  });

window.Echo.private(`chat.room.${props.room.id}`)
  .listen('MessageSent', (e) => {
    props.messages.push(e.message);
    nextTick(() => {
      scrollToBottom();
    });
  });

const scrollToBottom = () => {
  if (scrollAnchor.value) {
    scrollAnchor.value.scrollIntoView({ behavior: 'smooth' });
  }
};
</script>

<template>
  <section class="relative border h-full w-full">
    <header class="absolute top-0 h-[50px] w-full border-b flex items-center px-4">
      <h2 v-if="props.member">{{ props.member.user.name }}</h2>
      <h2 v-else>{{ props.room.name }}</h2>
    </header>
    <section class="pt-[50px] pb-[100px] h-full overflow-y-auto">
      <div class="h-full p-4">
        <ul class="h-full space-y-4 overflow-x-scroll">
          <li v-for="message in messages" :key="message.id" class="flex items-start gap-4 p-4" :class="{
            'justify-end': message.sender_id === $page.props.auth.user.id,
            'justify-start': message.sender_id !== $page.props.auth.user.id
          }">
            <div class="flex flex-col p-2 rounded-lg" :class="{
              'bg-[rgb(222,233,255)]': message.sender_id === $page.props.auth.user.id,
              'bg-gray-100': message.sender_id !== $page.props.auth.user.id
            }">
              <span class="text-sm text-gray-600">{{ message.message }}</span>
              <span class="text-xs text-gray-400">{{ message.created_at }}</span>
            </div>
          </li>
          <div ref="scrollAnchor"></div>
        </ul>
      </div>
    </section>
    <footer class="absolute bottom-0 w-full h-[100px] border-t flex items-center px-4">
      <div class="relative flex items-center w-full py-4">
        <form class="relative flex items-center w-full">
          <textarea v-model="form.message" rows="2" placeholder="Type your message here..."
            class="absolute rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1 block w-full"></textarea>
          <button type="button" @click="sendMessage" :disabled="form.processing"
            class="absolute right-0 inline-flex items-center rounded-full border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none active:bg-gray-900">Send</button>
        </form>
      </div>
    </footer>
  </section>
</template>