<template>
  <div class="grid">
    <div class="col-12">
      <div class="card">
        <div class="card pb-8">
          <h6 class="align-self-center">Current Month:</h6>
          <Calendar
            v-model="currentMonth"
            class="align-self-center"
            view="month"
            dateFormat="mm-yy"
            :yearNavigator="true"
            yearRange="2000:2030"
            showIcon
            @date-select="refreshTransactions(currentMonth)"
            style="width: 50%"
          />
        </div>
        <DataTable
          :value="transactions"
          v-model:selection="selectedTransactions"
          dataKey="id"
          :rowHover="true"
          autoLayout="true"
        >
          <Column selectionMode="multiple" style="width: 10%"></Column>
          <Column field="date" header="Date" style="width: 20%">
            <template #body="slotProps">
              {{ services.utilityService.removeYear(slotProps.data.date) }}
            </template>
          </Column>
          <Column
            field="category_label"
            header="Category"
            style="width: 35%"
            class="font-medium"
          >
            <template #body="slotProps">
              <Avatar
                :icon="slotProps.data.category_icon"
                class="text-xl"
                :style="['background-color:' + slotProps.data.category_color]"
                shape="circle"
                size="medium"
              />
              <span
                style="margin-left: 0.5em; vertical-align: middle"
                class="image-text"
                >{{ slotProps.data.category_label }}</span
              >
            </template>
          </Column>
          <Column field="notes" header="Notes"></Column>
          <Column field="label_name" header="Labels">
            <template #body="slotProps">
              <Chip
                v-for="label in slotProps.data.label_name"
                :key="label"
                class="m-1"
              >
                {{ label }}
              </Chip>
            </template>
          </Column>
          <Column field="readableTotal" class="text-right">
            <template #body="slotProps">
              <p
                :class="[
                  slotProps.data.type == '-'
                    ? 'font-bold text-pink-600'
                    : 'font-bold text-green-600',
                ]"
              >
                {{
                  services.utilityService.formatCurrency(
                    slotProps.data.total,
                    slotProps.data.type
                  )
                }}
              </p>
            </template>
          </Column>
          <Column style="width: 15%">
            <template #header> Edit </template>
            <template #body="slotProps">
              <Button
                icon="pi pi-pencil"
                type="button"
                class="p-button-text"
                @click="loadTransaction(slotProps.data.id)"
              ></Button>
            </template>
          </Column>
        </DataTable>

        <Dialog
          header="Edit Transaction"
          v-model:visible="display.seeTransaction"
          :breakpoints="{ '960px': '75vw' }"
          :style="{ width: '45vw' }"
          :modal="true"
          dismissableMask="true"
        >
          <SelectButton
            v-model="transaction.selectedType"
            :options="transaction.types"
            optionLabel="name"
            class="m-1 text-center"
            optionValue="name"
          />

          <form
            @submit.prevent="sendModifiedTransaction(!v$.$invalid)"
            class="p-fluid p-grid"
          >
            <div class="p-col-12">
              <label for="total">Total</label>
              <div class="p-inputgroup">
                <span class="p-inputgroup-addon">
                  <i
                    :class="[
                      transaction.selectedType == 'Cost'
                        ? 'p-button-success pi pi-minus'
                        : 'p-button-danger pi pi-plus',
                    ]"
                  ></i>
                </span>
                <InputNumber
                  id="total"
                  v-model="v$.transaction.total.$model"
                  mode="currency"
                  currency="EUR"
                  locale="it-IT"
                />
              </div>
            </div>
            <div class="mt-3 p-col">
              <label for="category">Notes</label>
              <Textarea
                v-model="transaction.notes"
                placeholder="Your Notes"
                :autoResize="true"
                rows="3"
                cols="30"
                required
              />
            </div>
            <div class="mt-3 p-col">
              <label for="category">Date</label>
              <div class="p-inputgroup">
                <Calendar
                  v-model="v$.transaction.date.$model"
                  dateFormat="dd-mm-yy"
                  :class="{
                    'p-invalid': v$.transaction.date.$invalid && submitted,
                  }"
                />
                <Button
                  icon="pi pi-times"
                  @click="v$.transaction.date.$model = ''"
                />
              </div>
              <small
                v-if="
                  (v$.transaction.date.$invalid && submitted) ||
                  v$.transaction.date.$pending.$response
                "
                class="p-error"
                >{{
                  v$.transaction.date.required.$message.replace("Value", "Date")
                }}</small
              >
            </div>
            <div class="grid">
              <div class="col-6">
                <div class="mt-3 p-col">
                  <label for="category">Category</label>
                  <TreeSelect
                    v-model="v$.transaction.treeSelects.selectedCategory.$model"
                    :options="lists.categories"
                    scrollHeight="200px"
                    placeholder="Select"
                    selectionMode="single"
                    :class="{
                      'p-invalid':
                        v$.transaction.treeSelects.selectedCategory.$invalid &&
                        submitted,
                    }"
                  />
                  <small
                    v-if="
                      (v$.transaction.treeSelects.selectedCategory.$invalid &&
                        submitted) ||
                      v$.transaction.treeSelects.selectedCategory.$pending
                        .$response
                    "
                    class="p-error"
                    >{{
                      v$.transaction.treeSelects.selectedCategory.required.$message.replace(
                        "Value",
                        "Category"
                      )
                    }}</small
                  >
                </div>
              </div>
              <div class="col-6">
                <div class="mt-3 p-col">
                  <label for="state">State</label>
                  <TreeSelect
                    v-model="v$.transaction.treeSelects.selectedState.$model"
                    :options="lists.states"
                    scrollHeight="200px"
                    placeholder="Select"
                    selectionMode="single"
                    :class="{
                      'p-invalid':
                        v$.transaction.treeSelects.selectedState.$invalid &&
                        submitted,
                    }"
                  />
                  <small
                    v-if="
                      (v$.transaction.treeSelects.selectedState.$invalid &&
                        submitted) ||
                      v$.transaction.treeSelects.selectedState.$pending
                        .$response
                    "
                    class="p-error"
                    >{{
                      v$.transaction.treeSelects.selectedState.required.$message.replace(
                        "Value",
                        "State"
                      )
                    }}</small
                  >
                </div>
              </div>
              <div class="col-6">
                <div class="mt-3 p-col">
                  <label for="state">Timing</label>
                  <TreeSelect
                    v-model="v$.transaction.treeSelects.selectedTiming.$model"
                    :options="lists.timings"
                    scrollHeight="200px"
                    placeholder="Select"
                    selectionMode="single"
                    :class="{
                      'p-invalid':
                        v$.transaction.treeSelects.selectedTiming.$invalid &&
                        submitted,
                    }"
                  /><small
                    v-if="
                      (v$.transaction.treeSelects.selectedTiming.$invalid &&
                        submitted) ||
                      v$.transaction.treeSelects.selectedTiming.$pending
                        .$response
                    "
                    class="p-error"
                    >{{
                      v$.transaction.treeSelects.selectedTiming.required.$message.replace(
                        "Value",
                        "Timing"
                      )
                    }}</small
                  >
                </div>
              </div>
              <div class="col-6">
                <div class="mt-3 p-col">
                  <label for="state">Method</label>
                  <TreeSelect
                    v-model="v$.transaction.treeSelects.selectedMethod.$model"
                    :options="lists.methods"
                    scrollHeight="200px"
                    placeholder="Select"
                    selectionMode="single"
                    :class="{
                      'p-invalid':
                        v$.transaction.treeSelects.selectedMethod.$invalid &&
                        submitted,
                    }"
                  /><small
                    v-if="
                      (v$.transaction.treeSelects.selectedMethod.$invalid &&
                        submitted) ||
                      v$.transaction.treeSelects.selectedMethod.$pending
                        .$response
                    "
                    class="p-error"
                    >{{
                      v$.transaction.treeSelects.selectedMethod.required.$message.replace(
                        "Value",
                        "Method"
                      )
                    }}</small
                  >
                </div>
              </div>
              <div class="col-12">
                <div class="mt-3 p-col">
                  <label for="state">Labels</label>
                  <TreeSelect
                    v-model="transaction.treeSelects.selectedLabels"
                    :options="lists.labels"
                    selectionMode="checkbox"
                    scrollHeight="200px"
                    placeholder="Select"
                    display="chip"
                    emptyMessage="No Labels Selected"
                  />
                </div>
              </div>
            </div>
          </form>

          <div class="grid">
            <div class="col-12 text-center">
              <Button
                label="Save"
                class="
                  mt-2
                  p-button-success p-button-rounded
                  text-white-alpha-90
                  font-medium
                "
                icon="pi pi-check"
                type="Submit"
                @click="sendModifiedTransaction(!v$.$invalid)"
              />
            </div>
          </div>
        </Dialog>
      </div>
    </div>
  </div>
</template>

<script>
import TransactionService from "../service/TransactionService";
import UtilityService from "../service/UtilityService";
import CategoryService from "../service/CategoryService";
import StateService from "../service/StateService";
import TimingService from "../service/TimingService";
import MethodService from "../service/MethodService";
import LabelService from "../service/LabelService";

import useVuelidate from "@vuelidate/core";
import { required, numeric } from "@vuelidate/validators";

export default {
  setup() {
    return { v$: useVuelidate() };
  },
  data() {
    return {
      services: {
        transactionService: null,
        categoryService: null,
        stateService: null,
        timingService: null,
        methodService: null,
        labelService: null,
        utilityService: null,
      },
      display: {
        seeTransaction: false,
      },
      lists: {
        transactions: null,
        categories: null,
        states: null,
        timings: null,
        methods: null,
        labels: null,
      },
      transaction: {
        id: null,
        types: [{ name: "Cost" }, { name: "Earning" }, { name: "Transfer" }],
        selectedType: "Cost",
        total: 0.0,
        notes: null,
        date: null,
        treeSelects: {
          selectedCategory: null,
          selectedState: null,
          selectedTiming: null,
          selectedMethod: null,
          selectedLabels: [],
        },
      },
      transactions: null,
      selectedTransactions: null,
      currentMonth: null,
      submitted: false,
    };
  },

  validations() {
    return {
      transaction: {
        total: { numeric },
        date: { required },
        treeSelects: {
          selectedCategory: { required },
          selectedState: { required },
          selectedTiming: { required },
          selectedMethod: { required },
          selectedLabels: {},
        },
      },
    };
  },

  created() {
    this.services.transactionService = new TransactionService();
    this.services.categoryService = new CategoryService();
    this.services.stateService = new StateService();
    this.services.timingService = new TimingService();
    this.services.methodService = new MethodService();
    this.services.labelService = new LabelService();

    this.services.utilityService = new UtilityService();

    this.currentMonth = this.services.utilityService.getCurrentMonth();
  },
  mounted() {
    this.refreshTransactions(this.currentMonth);

    this.services.categoryService
      .getTree()
      .then((data) => (this.lists.categories = data));

    this.services.stateService
      .getTree()
      .then((data) => (this.lists.states = data));

    this.services.timingService
      .getTree()
      .then((data) => (this.lists.timings = data));

    this.services.methodService
      .getTree()
      .then((data) => (this.lists.methods = data));

    this.services.labelService
      .getTree()
      .then((data) => (this.lists.labels = data));
  },
  methods: {
    loadTransaction(transactionId) {
      this.services.transactionService.getTransaction(transactionId).then(
        (data) => (
          // console.table(data),
          // console.log(data.label_id),
          (this.transaction.id = data.id),
          (this.transaction.total = data.total),
          (this.transaction.notes = data.notes),
          (this.transaction.date = new Date(
            this.services.utilityService.revertDateString(data.date)
          )),
          data.type == "-"
            ? (this.transaction.selectedType = "Cost")
            : (this.transaction.selectedType = "Earning"),
          (this.transaction.treeSelects.selectedCategory = {
            [data.category_id]: true,
          }),
          (this.transaction.treeSelects.selectedState = {
            [data.state_id]: true,
          }),
          (this.transaction.treeSelects.selectedTiming = {
            [data.timing_id]: true,
          }),
          (this.transaction.treeSelects.selectedMethod = {
            [data.method_id]: true,
          }),
          (this.transaction.treeSelects.selectedLabels = { 0: 2 }),
          data["label_id"] == null
            ? null
            : data["label_id"].forEach((element) => {
                this.transaction.treeSelects.selectedLabels[`${element}`] = {
                  checked: true,
                  partialChecked: false,
                };
              })
        )
      );

      this.display.seeTransaction = true;
    },

    refreshTransactions(currentMonth) {
      let fullDate = this.services.utilityService.formatDate(currentMonth);
      this.services.transactionService
        .getMonthTransactions(fullDate)
        .then((data) => (this.transactions = data));
    },

    sendModifiedTransaction(isFormValid) {
      this.submitted = true;

      if (!isFormValid) {
        return;
      }

      //To print the format of the selected labels:
      console.log(JSON.stringify(this.transaction.treeSelects.selectedLabels));

      // Extracting the obejct indices
      let selectedLabels = Object.keys(
        this.transaction.treeSelects.selectedLabels
      );

      // Removing the first item because it's always '2'
      selectedLabels.shift();

      // We have the final array with the id of the selected labels
      // console.log(selectedLabels);

      // Initialize the stringe/date as Date
      let localDate = new Date(this.transaction.date);

      axios
        .put("/api/transactions/" + this.transaction.id, {
          total: this.transaction.total,
          date: this.services.utilityService.toJSONLocal(localDate),
          notes: this.transaction.notes,
          type: this.transaction.selectedType == "Cost" ? "-" : "+",
          category_id: Object.keys(
            this.transaction.treeSelects.selectedCategory
          )[0],
          state_id: Object.keys(this.transaction.treeSelects.selectedState)[0],
          timing_id: Object.keys(
            this.transaction.treeSelects.selectedTiming
          )[0],
          method_id: Object.keys(
            this.transaction.treeSelects.selectedMethod
          )[0],
          labels_id: selectedLabels,
        })
        .catch(function (error) {
          console.log(error.response);
        })
        .then((response) => {
          // this.resetForm();
          this.refreshTransactions(this.currentMonth);
          console.log(response);

          this.display.seeTransaction = false;
        });
    },
  },
};
</script>

<style scoped lang="scss">
.customer-badge {
  border-radius: 2px;
  padding: 0.25em 0.5rem;
  text-transform: uppercase;
  font-weight: 700;
  font-size: 12px;
  letter-spacing: 0.3px;

  &.status-qualified {
    background: #c8e6c9;
    color: #256029;
  }

  &.status-unqualified {
    background: #ffcdd2;
    color: #c63737;
  }

  &.status-negotiation {
    background: #feedaf;
    color: #8a5340;
  }

  &.status-new {
    background: #b3e5fc;
    color: #23547b;
  }

  &.status-renewal {
    background: #eccfff;
    color: #694382;
  }

  &.status-proposal {
    background: #ffd8b2;
    color: #805b36;
  }
}

.product-badge {
  border-radius: 2px;
  padding: 0.25em 0.5rem;
  text-transform: uppercase;
  font-weight: 700;
  font-size: 12px;
  letter-spacing: 0.3px;

  &.status-instock {
    background: #c8e6c9;
    color: #256029;
  }

  &.status-outofstock {
    background: #ffcdd2;
    color: #c63737;
  }

  &.status-lowstock {
    background: #feedaf;
    color: #8a5340;
  }
}

.order-badge {
  border-radius: 2px;
  padding: 0.25em 0.5rem;
  text-transform: uppercase;
  font-weight: 700;
  font-size: 12px;
  letter-spacing: 0.3px;

  &.order-delivered {
    background: #c8e6c9;
    color: #256029;
  }

  &.order-cancelled {
    background: #ffcdd2;
    color: #c63737;
  }

  &.order-pending {
    background: #feedaf;
    color: #8a5340;
  }

  &.order-returned {
    background: #eccfff;
    color: #694382;
  }
}
</style>
