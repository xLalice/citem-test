<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h4 class="mb-0">Manila FAME Registration</h4>
                        <small class="text-muted"
                            >Step {{ currentStep }} of 3</small
                        >
                        <div class="progress mt-2" style="height: 5px">
                            <div
                                class="progress-bar bg-dark"
                                :style="{
                                    width: (currentStep / 3) * 100 + '%',
                                }"
                            ></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="submitted" class="text-center py-5">
                            <h3 class="text-success">
                                Registration Successful!
                            </h3>
                            <p>
                                Thank you for registering. We will review your
                                application shortly.
                            </p>
                            <button
                                @click="resetForm"
                                class="btn btn-outline-dark mt-3"
                            >
                                Register Another
                            </button>
                        </div>

                        <div v-else>
                            <AccountInformation
                                v-if="currentStep === 1"
                                v-model:formData="form"
                                @next="nextStep"
                            />

                            <CompanyInformation
                                v-if="currentStep === 2"
                                v-model:formData="form"
                                @prev="prevStep"
                                @next="nextStep"
                            />

                            <RegistrationSummary
                                v-if="currentStep === 3"
                                :formData="form"
                                :loading="loading"
                                :errors="errors"
                                @prev="prevStep"
                                @submit="submitRegistration"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import axios from "axios";
import AccountInformation from "./components/AccountInformation.vue";
import CompanyInformation from "./components/CompanyInformation.vue";
import RegistrationSummary from "./components/RegistrationSummary.vue";

const currentStep = ref(1);
const submitted = ref(false);
const loading = ref(false);
const errors = ref({});

const form = reactive({
    first_name: "",
    last_name: "",
    email: "",
    username: "",
    password: "",
    password_confirmation: "",
    type: "Buyer",
    company_name: "",
    address: "",
    city: "",
    region: "",
    country: "",
    year_established: "",
    website: "",
    brochure: null,
});

const nextStep = () => currentStep.value++;
const prevStep = () => currentStep.value--;

const submitRegistration = async () => {
    loading.value = true;
    errors.value = {};

    let data = new FormData();
    for (const key in form) {
        if (form[key] !== null) {
            data.append(key, form[key]);
        }
    }

    try {
        await axios.post("/api/register", data, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        submitted.value = true;
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
            alert("Please fix the errors before submitting.");
        } else {
            alert("Server Error: " + error.message);
        }
    } finally {
        loading.value = false;
    }
};

const resetForm = () => {
    submitted.value = false;
    currentStep.value = 1;
    Object.keys(form).forEach(
        (key) => (form[key] = key === "type" ? "Buyer" : ""),
    );
};
</script>
