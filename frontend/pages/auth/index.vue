<template>
  <!-- <div class="login-page">
    <h1>Login</h1>
    <form @submit.prevent="handleLogin">
      <div>
        <label for="username">Username:</label>
        <input v-model="form.username" id="username" type="text" required />
      </div>
      <div>
        <label for="password">Password:</label>
        <input v-model="form.password" id="password" type="password" required />
      </div>
      <button type="submit">Login</button>
    </form>
    <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
  </div> -->
  <section class="bg-white dark:bg-dark-2 flex flex-wrap min-h-[100vh]">
    <div class="lg:w-1/2 lg:block hidden">
      <div class="flex items-center flex-col h-full justify-center">
        <img src="/assets/images/auth/auth-img.png" alt="" />
      </div>
    </div>
    <div class="lg:w-1/2 py-8 px-6 flex flex-col justify-center">
      <div class="lg:max-w-[464px] mx-auto w-full">
        <div>
          <a href="index.html" class="mb-2.5 max-w-[290px]">
            <img src="/assets/images/logo.png" alt="" />
          </a>
          <h4 class="mb-3">Sign In to your Account</h4>
          <p class="mb-8 text-secondary-light text-lg">
            Welcome back! please enter your detail
          </p>
        </div>
        <form @submit.prevent="handleLogin">
          <div class="icon-field mb-4 relative">
            <span
              class="absolute start-4 top-1/2 -translate-y-1/2 pointer-events-none flex text-xl"
            >
              <Icon name="mage:email"></Icon>
            </span>
            <input
              v-model="form.email"
              type="text"
              class="text-neutral-400 form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
              placeholder="Username / Email"
            />
          </div>
          <div class="relative mb-5">
            <div class="icon-field">
              <span
                class="absolute start-4 top-1/2 -translate-y-1/2 pointer-events-none flex text-xl"
              >
                <Icon name="solar:lock-password-outline"></Icon>
              </span>
              <input
                type="password"
                v-model="form.password"
                class="text-neutral-400 form-control h-[56px] ps-11 border-neutral-300 bg-neutral-50 dark:bg-dark-2 rounded-xl"
                id="your-password"
                placeholder="Password"
              />
            </div>
            <span
              class="toggle-password ri-eye-line cursor-pointer absolute end-0 top-1/2 -translate-y-1/2 me-4 text-secondary-light"
              data-toggle="#your-password"
              @click="togglePasswordVisibility('your-password', this)"
            ></span>
          </div>
          <div class="mt-7">
            <div class="flex justify-between gap-2">
              <div class="flex items-center">
                <input
                  class="form-check-input border border-neutral-300"
                  type="checkbox"
                  value=""
                  id="remeber"
                />
                <label class="ps-2" for="remeber">Remember me </label>
              </div>
              <a
                href="javascript:void(0)"
                class="text-primary-600 font-medium hover:underline"
                >Forgot Password?</a
              >
            </div>
          </div>

          <fwb-button
            type="submit"
            class="btn btn-primary justify-center text-sm btn-sm px-3 py-4 w-full rounded-xl mt-8"
            :loading="isLoading"
          >
            Sign In
          </fwb-button>

          <div
            class="mt-8 center-border-horizontal text-center relative before:absolute before:w-full before:h-[1px] before:top-1/2 before:-translate-y-1/2 before:bg-neutral-300 before:start-0"
          >
            <span class="bg-white dark:bg-dark-2 z-[2] relative px-4"
              >Or sign in with</span
            >
          </div>
          <div class="mt-8 flex items-center gap-3">
            <button
              type="button"
              class="font-semibold text-neutral-600 dark:text-neutral-200 py-4 px-6 w-1/2 border rounded-xl text-base flex items-center justify-center gap-3 line-height-1 hover:bg-primary-50"
            >
              <Icon
                name="ic:baseline-facebook"
                class="text-primary-600 text-xl line-height-1"
              ></Icon>
              Google
            </button>
            <button
              type="button"
              class="font-semibold text-neutral-600 dark:text-neutral-200 py-4 px-6 w-1/2 border rounded-xl text-base flex items-center justify-center gap-3 line-height-1 hover:bg-primary-50"
            >
              <Icon
                name="logos:google-icon"
                class="text-primary-600 text-xl line-height-1"
              ></Icon>
              Google
            </button>
          </div>
          <div class="mt-8 text-center text-sm">
            <p class="mb-0">
              Don't have an account?
              <a
                href="sign-up.html"
                class="text-primary-600 font-semibold hover:underline"
                >Sign Up</a
              >
            </p>
          </div>
        </form>
        <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { FwbButton } from "flowbite-vue";
import { fetch } from "~/utils/fetchWrapper";

definePageMeta({
  layout: "auth",
});
const form = ref({
  email: "",
  password: "",
});
const isLoading = ref(false);

const errorMessage = ref(null);
const router = useRouter();

async function handleLogin() {
  isLoading.value = true;
  errorMessage.value = null;

  await fetch
    .post("http://localhost:8000/api/login", form.value)
    .then((response) => {
      isLoading.value = false;
      // const expiresIn = response.data.expires_in;
      // const expirationTime = Date.now() + expiresIn * 1000;

      sessionStorage.setItem("auth_token", response.token);
      // sessionStorage.setItem("token_expiration", expirationTime);

      if (sessionStorage.getItem("auth_token")) {
        router.push("/dashboard");
      }
    })
    .catch((error) => {
      isLoading.value = false;
      errorMessage.value = error.message || "Login failed";
    });
  }
function togglePasswordVisibility(inputId, toggleElement) {
  const input = document.getElementById(inputId);

  if (input.type === "password") {
    input.type = "text";
    toggleElement.classList.remove("ri-eye-line");
    toggleElement.classList.add("ri-eye-off-line");
  } else {
    input.type = "password";
    toggleElement.classList.remove("ri-eye-off-line");
    toggleElement.classList.add("ri-eye-line");
  }
}
</script>

<style scoped>
.login-page {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
}
.error {
  color: red;
}
</style>
