{{-- Modal--}}
<div id="editAddPriceModal">
    <modal
            name="add-local-price-modal"
            :click-to-close="false"
            v-cloak
            @before-open="beforeOpen($event)"
            width="60%"
    >
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button class="btn btn-danger" @click="closeAddPriceModal">Close</button>
                    </div>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="form-body">
                                <div class="row">
                                    {{--Province--}}
                                    <div class="col-xs-12 col-md-6" >
                                        <div class="form-group">
                                            <label for="province"
                                                   class="control-label col-md-3">จังหวัด</label>
                                            <div class="col-md-9">
                                                <multiselect @close="getAmphoes(index)"
                                                             v-model="form.province"
                                                             placeholder="" label="name" track-by="id"
                                                             :options="provinces" :option-height="104"
                                                             :allow-empty="false"
                                                             :show-labels="false">
                                                    <template slot="option" slot-scope="props">
                                                        <div class="option__desc">
                                                            <span class="option__title">@{{ props.option.name }}</span>
                                                        </div>
                                                    </template>
                                                </multiselect>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    {{--Amphoe--}}
                                    <div class="col-xs-12 col-md-6" >
                                        <div class="form-group">
                                            <label for="province"
                                                   class="control-label col-md-3">จังหวัด</label>
                                            <div class="col-md-9">
                                                <multiselect @close="getAmphoes(index)"
                                                             v-model="form.province"
                                                             placeholder="" label="name" track-by="id"
                                                             :options="provinces" :option-height="104"
                                                             :allow-empty="false"
                                                             :show-labels="false">
                                                    <template slot="option" slot-scope="props">
                                                        <div class="option__desc">
                                                            <span class="option__title">@{{ props.option.name }}</span>
                                                        </div>
                                                    </template>
                                                </multiselect>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </modal>
</div>