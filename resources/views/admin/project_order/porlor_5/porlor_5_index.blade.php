<modal
        name="porlor-5-modal"
        :click-to-close="false"
        v-cloak
        @before-open="beforeOpenPorlor5Modal($event)"
        @before-close="beforeClosePorlor5Modal"
        width="90%"
        height="auto"
        :scrollable="true"
>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button class="btn btn-danger" @click="closePorlor5Modal">Close</button>
                </div>
                <div class="panel-body">

                </div>
            </div>

        </div>
    </div>
</modal>