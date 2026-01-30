<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-fame">
                    <div class="card-header text-center">
                        <h2 class="mb-1" style="color: var(--fame-dark)">
                            MANILA
                            <span style="color: var(--fame-gold)">FAME</span>
                        </h2>
                        <p class="text-muted mb-3">Buyer Registration Portal</p>

                        <div
                            class="d-flex justify-content-between mb-1 small text-uppercase fw-bold"
                            style="color: var(--fame-dark)"
                        >
                            <span>Account</span>
                            <span>Company</span>
                            <span>Review</span>
                        </div>
                        <div
                            class="progress"
                            style="height: 4px; background-color: #eee"
                        >
                            <div
                                class="progress-bar"
                                role="progressbar"
                                :style="{
                                    width: (currentStep / 3) * 100 + '%',
                                    backgroundColor: 'var(--fame-gold)',
                                }"
                            ></div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div v-if="submitted" class="text-center py-5">
                            <h3
                                class="text-success mb-3"
                                style="
                                    font-family:
                                        &quot;Playfair Display&quot;, serif;
                                "
                            >
                                Registration Successful!
                            </h3>
                            <p class="text-muted">
                                Thank you for joining us. Please check your
                                email for confirmation.
                            </p>
                            <button
                                @click="resetForm"
                                class="btn btn-fame-outline mt-3"
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

                <div class="text-center mt-4 text-muted small">
                    &copy; 2026 CITEM. All Rights Reserved.
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
