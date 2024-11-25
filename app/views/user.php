<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-body-tertiary">
    <div class="col-md-6 p-lg-5 mx-auto my-5">
      <h1 @click="click" class="display-3 fw-bold">{{ firstname }} {{ lastname }}</h1>
      <h3 @mouseenter="mouseEnter" @mouseleave="mouseLeave" class="fw-normal text-muted mb-3">{{ email }}</h3>
    </div>
</div>
<hello-coremvc></hello-coremvc>