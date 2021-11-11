<template>
  <div class="grid">
    <div class="col-12 lg:col-6 xl:col-3">
      <div class="card mb-0">
        <div class="flex justify-content-between mb-3">
          <div>
            <span class="block text-500 font-medium mb-3">Costs</span>
            <Chip class="bg-pink-800 text-700 font-bold text-xl p-1">
              - {{ stats.totalCosts }} €
            </Chip>
          </div>
          <div
            class="
              flex
              align-items-center
              justify-content-center
              bg-pink-800
              border-round
            "
            style="width: 2.5rem; height: 2.5rem"
          >
            <i class="pi pi-shopping-cart text-pink-500 text-xl"></i>
          </div>
        </div>
        <span class="text-green-500 font-medium">24 new </span>
        <span class="text-500">since last visit</span>
      </div>
    </div>
    <div class="col-12 lg:col-6 xl:col-3">
      <div class="card mb-0">
        <div class="flex justify-content-between mb-3">
          <div>
            <span class="block text-500 font-medium mb-3">Earnings</span>
            <Chip class="bg-green-800 text-700 font-bold text-xl p-1">
              +{{ stats.totalEarnings }} €
            </Chip>
          </div>
          <div
            class="
              flex
              align-items-center
              justify-content-center
              bg-green-800
              border-round
            "
            style="width: 2.5rem; height: 2.5rem"
          >
            <i class="pi pi-euro text-green-500 text-xl"></i>
          </div>
        </div>
        <span class="text-green-500 font-medium">%52+ </span>
        <span class="text-500">since last week</span>
      </div>
    </div>
    <div class="col-12 lg:col-6 xl:col-3">
      <div class="card mb-0">
        <div class="flex justify-content-between mb-3">
          <div>
            <span class="block text-500 font-medium mb-3">Balance</span>
            <div class="text-900 font-medium text-xl">
              {{ stats.totalBalance }} €
            </div>
          </div>
          <div
            class="
              flex
              align-items-center
              justify-content-center
              bg-purple-800
              border-round
            "
            style="width: 2.5rem; height: 2.5rem"
          >
            <i class="pi pi-wallet text-purple-500 text-xl"></i>
          </div>
        </div>
        <span class="text-green-500 font-medium">85 </span>
        <span class="text-500">responded</span>
      </div>
    </div>

    <div class="col-12 lg:col-6 xl:col-3">
      <div class="card pb-8">
        <h6 class="align-self-center">Current Month:</h6>
        <Calendar
          v-model="currentMonth"
          view="month"
          dateFormat="mm/yy"
          :yearNavigator="true"
          yearRange="2000:2030"
          showIcon
          @date-select="
            refreshTransactions(currentMonth);
            refreshCharts(currentMonth);
            refreshStats(currentMonth);
          "
        />
      </div>
    </div>
    <!-- <div class="col-12 xl:col-6">
      <div class="card">
        <h5>Sales Overview</h5>
        <Chart type="line" :data="lineData" />
      </div>
    </div> -->
    <!-- <div class="col-12 xl:col-6">
      <div class="card">
        <h5>Sales Overview</h5>
        <Chart type="line" :data="lineData" />
      </div>
    </div> -->
    <div class="col-12 lg:col-6 xl:col-8">
      <div class="card">
        <h5>
          Latest Transactions
          <Button
            label="Add Transaction"
            icon="pi pi-plus-circle"
            iconPos="right"
            class="mr-2 mb-2 float-right"
            @click="display.addTransaction = true"
          ></Button>
        </h5>
        <Dialog
          header="Add Transaction"
          v-model:visible="display.addTransaction"
          :breakpoints="{ '960px': '75vw' }"
          :style="{ width: '45vw' }"
          :modal="true"
          dismissableMask="true"
        >
          <SelectButton
            v-model="dialog.selectedType"
            :options="dialog.types"
            optionLabel="name"
            class="m-1 text-center"
            optionValue="name"
          />

          <form
            @submit.prevent="sendNewTransaction(!v$.$invalid)"
            class="p-fluid p-grid"
          >
            <div class="p-col-12">
              <label for="total">Total</label>
              <div class="p-inputgroup">
                <span class="p-inputgroup-addon">
                  <i
                    :class="[
                      dialog.selectedType == 'Cost'
                        ? 'p-button-success pi pi-minus'
                        : 'p-button-danger pi pi-plus',
                    ]"
                  ></i>
                </span>
                <InputNumber
                  id="total"
                  v-model="v$.dialog.total.$model"
                  mode="currency"
                  currency="EUR"
                  locale="it-IT"
                />
              </div>
            </div>
            <div class="mt-3 p-col">
              <label for="category">Notes</label>
              <Textarea
                v-model="dialog.notes"
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
                  v-model="v$.dialog.date.$model"
                  dateFormat="mm-dd-yy"
                  :class="{
                    'p-invalid': v$.dialog.date.$invalid && submitted,
                  }"
                />
                <Button
                  icon="pi pi-times"
                  @click="v$.dialog.date.$model = ''"
                />
              </div>
              <small
                v-if="
                  (v$.dialog.date.$invalid && submitted) ||
                  v$.dialog.date.$pending.$response
                "
                class="p-error"
                >{{
                  v$.dialog.date.required.$message.replace("Value", "Date")
                }}</small
              >
            </div>
            <div class="grid">
              <div class="col-6">
                <div class="mt-3 p-col">
                  <label for="category">Category</label>
                  <TreeSelect
                    v-model="v$.dialog.treeSelects.selectedCategory.$model"
                    :options="lists.categories"
                    scrollHeight="200px"
                    placeholder="Select"
                    selectionMode="single"
                    :class="{
                      'p-invalid':
                        v$.dialog.treeSelects.selectedCategory.$invalid &&
                        submitted,
                    }"
                  />
                  <small
                    v-if="
                      (v$.dialog.treeSelects.selectedCategory.$invalid &&
                        submitted) ||
                      v$.dialog.treeSelects.selectedCategory.$pending.$response
                    "
                    class="p-error"
                    >{{
                      v$.dialog.treeSelects.selectedCategory.required.$message.replace(
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
                    v-model="v$.dialog.treeSelects.selectedState.$model"
                    :options="lists.states"
                    scrollHeight="200px"
                    placeholder="Select"
                    selectionMode="single"
                    :class="{
                      'p-invalid':
                        v$.dialog.treeSelects.selectedState.$invalid &&
                        submitted,
                    }"
                  />
                  <small
                    v-if="
                      (v$.dialog.treeSelects.selectedState.$invalid &&
                        submitted) ||
                      v$.dialog.treeSelects.selectedState.$pending.$response
                    "
                    class="p-error"
                    >{{
                      v$.dialog.treeSelects.selectedState.required.$message.replace(
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
                    v-model="v$.dialog.treeSelects.selectedTiming.$model"
                    :options="lists.timings"
                    scrollHeight="200px"
                    placeholder="Select"
                    selectionMode="single"
                    :class="{
                      'p-invalid':
                        v$.dialog.treeSelects.selectedTiming.$invalid &&
                        submitted,
                    }"
                  /><small
                    v-if="
                      (v$.dialog.treeSelects.selectedTiming.$invalid &&
                        submitted) ||
                      v$.dialog.treeSelects.selectedTiming.$pending.$response
                    "
                    class="p-error"
                    >{{
                      v$.dialog.treeSelects.selectedTiming.required.$message.replace(
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
                    v-model="v$.dialog.treeSelects.selectedMethod.$model"
                    :options="lists.methods"
                    scrollHeight="200px"
                    placeholder="Select"
                    selectionMode="single"
                    :class="{
                      'p-invalid':
                        v$.dialog.treeSelects.selectedMethod.$invalid &&
                        submitted,
                    }"
                  /><small
                    v-if="
                      (v$.dialog.treeSelects.selectedMethod.$invalid &&
                        submitted) ||
                      v$.dialog.treeSelects.selectedMethod.$pending.$response
                    "
                    class="p-error"
                    >{{
                      v$.dialog.treeSelects.selectedMethod.required.$message.replace(
                        "Value",
                        "Method"
                      )
                    }}</small
                  >
                </div>
              </div>
            </div>
          </form>

          <div class="grid">
            <div class="col-12 text-center">
              <Button
                label="Add Transaction"
                class="
                  mt-2
                  p-button-success p-button-rounded
                  text-white-alpha-90
                  font-medium
                "
                icon="pi pi-check"
                type="Submit"
                @click="sendNewTransaction(!v$.$invalid)"
              />
            </div>
          </div>
        </Dialog>
        <DataTable :value="lists.transactions" :rows="5">
          <Column field="category_icon" :sortable="true" style="width: 12%">
            <template #body="slotProps">
              <Avatar
                :icon="slotProps.data.category_icon"
                shape="circle"
                class="text-xl bg-blue-600"
                size="large"
              />
            </template>
          </Column>
          <Column
            field="category_label"
            header="Category"
            :sortable="true"
            style="width: 25%"
          ></Column>
          <Column
            field="date"
            header="Date"
            :sortable="true"
            style="width: 25%"
          ></Column>
          <Column
            field="notes"
            header="Notes"
            :sortable="true"
            style="width: 25%"
          ></Column>
          <Column
            field="readableTotal"
            header="Total"
            :sortable="true"
            style="width: 25%"
          >
            <template #body="slotProps">
              <p
                :class="[
                  slotProps.data.type == '-'
                    ? 'font-bold text-pink-600'
                    : 'font-bold text-green-600',
                ]"
              >
                {{ formatCurrency(slotProps.data.total, slotProps.data.type) }}
              </p>
            </template>
          </Column>
          <!-- <Column style="width: 15%">
            <template #header> View </template>
            <template #body="slotProps">
              <Button
                icon="pi pi-search"
                type="button"
                class="p-button-text"
                @click="loadTransaction(slotProps.data.id)"
              ></Button>
            </template>
          </Column> -->
        </DataTable>
        <!-- <Dialog
          header="Add Transaction"
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
            @submit.prevent="sendNewTransaction(!v$.$invalid)"
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
                  dateFormat="mm-dd-yy"
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
            </div>
          </form>

          <div class="grid">
            <div class="col-12 text-center">
              <Button
                label="Add Transaction"
                class="
                  mt-2
                  p-button-success p-button-rounded
                  text-white-alpha-90
                  font-medium
                "
                icon="pi pi-check"
                type="Submit"
                @click="sendNewTransaction(!v$.$invalid)"
              />
            </div>
          </div>
        </Dialog> -->
      </div>
      <!-- <div class="card">
        <div class="flex justify-content-between align-items-center mb-5">
          <h5>Best Selling Products</h5>
          <div>
            <Button
              icon="pi pi-ellipsis-v"
              class="p-button-text p-button-plain p-button-rounded"
              @click="$refs.menu2.toggle($event)"
            ></Button>
            <Menu ref="menu2" :popup="true" :model="items"></Menu>
          </div>
        </div>
        <ul class="list-none p-0 m-0">
          <li
            class="
              flex flex-column
              md:flex-row md:align-items-center md:justify-content-between
              mb-4
            "
          >
            <div>
              <span class="text-900 font-medium mr-2 mb-1 md:mb-0"
                >Space T-Shirt</span
              >
              <div class="mt-1 text-600">Clothing</div>
            </div>
            <div class="mt-2 md:mt-0 flex align-items-center">
              <div
                class="
                  surface-300
                  border-round
                  overflow-hidden
                  w-10rem
                  lg:w-6rem
                "
                style="height: 8px"
              >
                <div class="bg-orange-500 h-full" style="width: 50%"></div>
              </div>
              <span class="text-orange-500 ml-3 font-medium">%50</span>
            </div>
          </li>
          <li
            class="
              flex flex-column
              md:flex-row md:align-items-center md:justify-content-between
              mb-4
            "
          >
            <div>
              <span class="text-900 font-medium mr-2 mb-1 md:mb-0"
                >Portal Sticker</span
              >
              <div class="mt-1 text-600">Accessories</div>
            </div>
            <div class="mt-2 md:mt-0 ml-0 md:ml-8 flex align-items-center">
              <div
                class="
                  surface-300
                  border-round
                  overflow-hidden
                  w-10rem
                  lg:w-6rem
                "
                style="height: 8px"
              >
                <div class="bg-cyan-500 h-full" style="width: 16%"></div>
              </div>
              <span class="text-cyan-500 ml-3 font-medium">%16</span>
            </div>
          </li>
          <li
            class="
              flex flex-column
              md:flex-row md:align-items-center md:justify-content-between
              mb-4
            "
          >
            <div>
              <span class="text-900 font-medium mr-2 mb-1 md:mb-0"
                >Supernova Sticker</span
              >
              <div class="mt-1 text-600">Accessories</div>
            </div>
            <div class="mt-2 md:mt-0 ml-0 md:ml-8 flex align-items-center">
              <div
                class="
                  surface-300
                  border-round
                  overflow-hidden
                  w-10rem
                  lg:w-6rem
                "
                style="height: 8px"
              >
                <div class="bg-pink-500 h-full" style="width: 67%"></div>
              </div>
              <span class="text-pink-500 ml-3 font-medium">%67</span>
            </div>
          </li>
          <li
            class="
              flex flex-column
              md:flex-row md:align-items-center md:justify-content-between
              mb-4
            "
          >
            <div>
              <span class="text-900 font-medium mr-2 mb-1 md:mb-0"
                >Wonders Notebook</span
              >
              <div class="mt-1 text-600">Office</div>
            </div>
            <div class="mt-2 md:mt-0 ml-0 md:ml-8 flex align-items-center">
              <div
                class="
                  surface-300
                  border-round
                  overflow-hidden
                  w-10rem
                  lg:w-6rem
                "
                style="height: 8px"
              >
                <div class="bg-green-500 h-full" style="width: 35%"></div>
              </div>
              <span class="text-green-500 ml-3 font-medium">%35</span>
            </div>
          </li>
          <li
            class="
              flex flex-column
              md:flex-row md:align-items-center md:justify-content-between
              mb-4
            "
          >
            <div>
              <span class="text-900 font-medium mr-2 mb-1 md:mb-0"
                >Mat Black Case</span
              >
              <div class="mt-1 text-600">Accessories</div>
            </div>
            <div class="mt-2 md:mt-0 ml-0 md:ml-8 flex align-items-center">
              <div
                class="
                  surface-300
                  border-round
                  overflow-hidden
                  w-10rem
                  lg:w-6rem
                "
                style="height: 8px"
              >
                <div class="bg-purple-500 h-full" style="width: 75%"></div>
              </div>
              <span class="text-purple-500 ml-3 font-medium">%75</span>
            </div>
          </li>
          <li
            class="
              flex flex-column
              md:flex-row md:align-items-center md:justify-content-between
              mb-4
            "
          >
            <div>
              <span class="text-900 font-medium mr-2 mb-1 md:mb-0"
                >Robots T-Shirt</span
              >
              <div class="mt-1 text-600">Clothing</div>
            </div>
            <div class="mt-2 md:mt-0 ml-0 md:ml-8 flex align-items-center">
              <div
                class="
                  surface-300
                  border-round
                  overflow-hidden
                  w-10rem
                  lg:w-6rem
                "
                style="height: 8px"
              >
                <div class="bg-teal-500 h-full" style="width: 40%"></div>
              </div>
              <span class="text-teal-500 ml-3 font-medium">%40</span>
            </div>
          </li>
        </ul>
      </div> -->
    </div>
    <div class="col-12 lg:col-6 xl:col-4">
      <div class="card">
        <h5>Monthly Cost</h5>
        <Chart ref="costsChart" type="doughnut" :data="lineDataTest" />
      </div>
    </div>
    <!-- <div class="col-12 xl:col-6">
      <div class="card">
        <div class="flex align-items-center justify-content-between mb-4">
          <h5>Notifications</h5>
          <div>
            <Button
              icon="pi pi-ellipsis-v"
              class="p-button-text p-button-plain p-button-rounded"
              @click="$refs.menu1.toggle($event)"
            ></Button>
            <Menu ref="menu1" :popup="true" :model="items"></Menu>
          </div>
        </div>

        <span class="block text-600 font-medium mb-3">TODAY</span>
        <ul class="p-0 mx-0 mt-0 mb-4 list-none">
          <li
            class="flex align-items-center py-2 border-bottom-1 surface-border"
          >
            <div
              class="
                w-3rem
                h-3rem
                flex
                align-items-center
                justify-content-center
                bg-blue-100
                border-circle
                mr-3
                flex-shrink-0
              "
            >
              <i class="pi pi-dollar text-xl text-blue-500"></i>
            </div>
            <span class="text-900 line-height-3"
              >Richard Jones
              <span class="text-700"
                >has purchased a blue t-shirt for
                <span class="text-blue-500">79$</span></span
              >
            </span>
          </li>
          <li class="flex align-items-center py-2">
            <div
              class="
                w-3rem
                h-3rem
                flex
                align-items-center
                justify-content-center
                bg-orange-100
                border-circle
                mr-3
                flex-shrink-0
              "
            >
              <i class="pi pi-download text-xl text-orange-500"></i>
            </div>
            <span class="text-700 line-height-3"
              >Your request for withdrawal of
              <span class="text-blue-500 font-medium">2500$</span> has been
              initiated.</span
            >
          </li>
        </ul>

        <span class="block text-600 font-medium mb-3">YESTERDAY</span>
        <ul class="p-0 m-0 list-none">
          <li
            class="flex align-items-center py-2 border-bottom-1 surface-border"
          >
            <div
              class="
                w-3rem
                h-3rem
                flex
                align-items-center
                justify-content-center
                bg-blue-100
                border-circle
                mr-3
                flex-shrink-0
              "
            >
              <i class="pi pi-dollar text-xl text-blue-500"></i>
            </div>
            <span class="text-900 line-height-3"
              >Keyser Wick
              <span class="text-700"
                >has purchased a black jacket for
                <span class="text-blue-500">59$</span></span
              >
            </span>
          </li>
          <li
            class="flex align-items-center py-2 border-bottom-1 surface-border"
          >
            <div
              class="
                w-3rem
                h-3rem
                flex
                align-items-center
                justify-content-center
                bg-pink-100
                border-circle
                mr-3
                flex-shrink-0
              "
            >
              <i class="pi pi-question text-xl text-pink-500"></i>
            </div>
            <span class="text-900 line-height-3"
              >Jane Davis
              <span class="text-700"
                >has posted a new questions about your product.</span
              >
            </span>
          </li>
        </ul>
      </div>
    </div> -->
  </div>
</template>

<script>
import TransactionService from "../service/TransactionService";
import CategoryService from "../service/CategoryService";
import StateService from "../service/StateService";
import TimingService from "../service/TimingService";
import MethodService from "../service/MethodService";

import useVuelidate from "@vuelidate/core";
import { required, numeric } from "@vuelidate/validators";

export default {
  setup() {
    return { v$: useVuelidate() };
  },

  data() {
    return {
      currentMonth: null,
      services: {
        transactionService: null,
        categoryService: null,
        stateService: null,
        timingService: null,
        methodService: null,
      },
      lists: {
        transactions: null,
        categories: null,
        states: null,
        timings: null,
        methods: null,
      },
      display: {
        addTransaction: false,
        seeTransaction: false,
      },
      stats: {
        totalCosts: null,
        totalEarnings: null,
        totalBalance: null,
      },
      dialog: {
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
        },
      },
      transaction: {
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
        },
      },
      lineData: {
        labels: [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
        ],
        datasets: [
          {
            label: "Revenue",
            data: [65, 59, 80, 81, 56, 55, 40],
            fill: false,
            backgroundColor: "#2f4860",
            borderColor: "#2f4860",
            tension: 0.4,
          },
          {
            label: "Sales",
            data: [28, 48, 40, 19, 86, 27, 90],
            fill: false,
            backgroundColor: "#00bb7e",
            borderColor: "#00bb7e",
            tension: 0.4,
          },
        ],
      },
      lineDataTest: {
        labels: [],
        datasets: [
          {
            data: [],
            backgroundColor: [
              "#FF6384",
              "#36A2EB",
              "#FFCE56",
              "#2DA635",
              "#65009F",
              "#654AFE",
              "#1F4FE6",
              "#D3ED7E",
              "#FF710D",
              "#81617E",
              "#208E68",
            ],
            hoverBackgroundColor: [
              "#FF6384",
              "#36A2EB",
              "#FFCE56",
              "#2DA635",
              "#65009F",
              "#654AFE",
              "#1F4FE6",
              "#D3ED7E",
              "#FF710D",
              "#81617E",
              "#208E68",
            ],
          },
        ],
      },
      items: [
        { label: "Add New", icon: "pi pi-fw pi-plus" },
        { label: "Remove", icon: "pi pi-fw pi-minus" },
      ],
      submitted: false,
    };
  },

  validations() {
    return {
      dialog: {
        total: { numeric },
        date: { required },
        treeSelects: {
          selectedCategory: { required },
          selectedState: { required },
          selectedTiming: { required },
          selectedMethod: { required },
        },
      },
      // transaction: {
      //   total: { numeric },
      //   date: { required },
      //   treeSelects: {
      //     selectedCategory: { required },
      //     selectedState: { required },
      //     selectedTiming: { required },
      //     selectedMethod: { required },
      //   },
      // },
    };
  },

  created() {
    this.services.transactionService = new TransactionService();
    this.services.categoryService = new CategoryService();
    this.services.stateService = new StateService();
    this.services.timingService = new TimingService();
    this.services.methodService = new MethodService();

    this.currentMonth = this.getCurrentMonth();
  },

  mounted() {
    this.refreshTransactions(this.currentMonth);
    this.refreshCharts(this.currentMonth);
    this.refreshStats(this.currentMonth);

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
  },

  methods: {
    loadTransaction(transactionId) {
      this.display.seeTransaction = true;

      this.services.transactionService.getTransaction(transactionId).then(
        (data) => (
          (this.transaction.total = data.total),
          (this.transaction.notes = data.notes),
          (this.transaction.date = data.date),
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
          })
        )
      );
    },

    refreshTransactions(currentMonth) {
      let fullDate = this.formatDate(currentMonth);
      this.services.transactionService
        .getMonthTransactions(fullDate)
        .then((data) => (this.lists.transactions = data));
    },

    refreshCharts(currentMonth) {
      let fullDate = this.formatDate(currentMonth);

      this.services.transactionService
        .getMonthStats(fullDate)
        .then(
          (data) => (
            (this.lineDataTest.labels = data.map((a) => a.label)),
            (this.lineDataTest.datasets[0].data = data.map((a) => a.total)),
            this.$refs.costsChart.refresh()
          )
        );
    },

    refreshStats(currentMonth) {
      this.services.transactionService
        .getTotalEarnings(this.formatDate(currentMonth))
        .then((data) => (this.stats.totalEarnings = data));
      this.services.transactionService
        .getTotalCosts(this.formatDate(currentMonth))
        .then((data) => (this.stats.totalCosts = data));
      this.services.transactionService
        .getTotalBalance(this.formatDate(currentMonth))
        .then((data) => (this.stats.totalBalance = data));
    },

    formatDate(date) {
      return [date.getMonth() + 1] + "/" + date.getFullYear();
    },

    formatCurrency(value, type) {
      return (
        type +
        value.toLocaleString("it-IT", { style: "currency", currency: "EUR" })
      );
    },

    getCurrentMonth() {
      const today = new Date();

      return today;
    },

    sendNewTransaction(isFormValid) {
      this.submitted = true;

      if (!isFormValid) {
        return;
      }

      axios
        .post("/api/transactions", {
          total: this.dialog.total,
          date: this.dialog.date.toString().slice(0, 10),
          notes: this.dialog.notes,
          type: this.dialog.selectedType == "Cost" ? "-" : "+",
          category_id: Object.keys(this.dialog.treeSelects.selectedCategory)[0],
          state_id: Object.keys(this.dialog.treeSelects.selectedState)[0],
          timing_id: Object.keys(this.dialog.treeSelects.selectedTiming)[0],
          method_id: Object.keys(this.dialog.treeSelects.selectedMethod)[0],
        })
        .catch(function (error) {
          console.log(error.response);
        })
        .then((response) => {
          this.resetForm();
          this.refreshTransactions(this.currentMonth);
          this.refreshCharts(this.currentMonth);
          this.refreshStats(this.currentMonth);
          this.display.addTransaction = false;
        });
    },

    resetForm() {
      this.dialog.total = 0.0;
      this.dialog.date = "";
      this.dialog.notes = "";
      this.dialog.selectedType = "Cost";
      this.dialog.treeSelects.selectedCategory = "";
      this.dialog.treeSelects.selectedState = "";
      this.dialog.treeSelects.selectedTiming = "";
      this.dialog.treeSelects.selectedMethod = "";

      this.submitted = false;
    },
  },
};
</script>