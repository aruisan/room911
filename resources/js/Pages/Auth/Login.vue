<template>
    <GuestLayout>
        <Head title="Login" />

                <form @submit.prevent="submit">
                    <div>
                        <TextInput
                            id="email"
                            type="email"
                            placeholder="Email"
                            class="mt-1 block w-full px-4 py-3 rounded-md bg-white/20 text-white focus:ring-2 focus:ring-blue-400"
                            v-model="form.email"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mt-4">
                        <TextInput
                            id="password"
                            type="password"
                            placeholder="Password"
                            class="mt-1 block w-full px-4 py-3 rounded-md bg-white/20 text-white focus:ring-2 focus:ring-blue-400"
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                        />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div class="flex justify-between items-center mt-4 text-white">
                        <label class="flex items-center">
                            <Checkbox name="remember" v-model:checked="form.remember" class="bg-white/20 text-white"/>
                            <span class="ml-2 text-sm">Remember me</span>
                        </label>

                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="underline text-sm hover:text-blue-300"
                        >
                            Forgot Password?
                        </Link>
                    </div>

                    <div class="mt-6 flex items-center justify-center">
                        <PrimaryButton class="w-full py-3 rounded-md bg-blue-600 text-white hover:bg-blue-700">
                            Login
                        </PrimaryButton>
                    </div>
                </form>
    </GuestLayout>
</template>

<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
