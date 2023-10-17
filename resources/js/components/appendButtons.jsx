const YourComponent = {
  props: {
    data: {
      type: Object
    }
  },
  render() {
    return (
      <div>
        <router-link class="btn btn-sm btn-primary" to={'feedbacks/' + this.data.id + '/edit'}>
          <i class="fas fa-edit"></i>
        </router-link>
        <button class="btn btn-sm btn-danger" onClick={() => this.delete(this.data.id)}>
          <i class="fas fa-trash"></i>
        </button>
      </div>
    );
  }
};

export default YourComponent;