export default {
  data() {
    return {
      methodOptions: [
        { label: 'GET', value: 'GET' },
        { label: 'POST', value: 'POST' },
        { label: 'PUT', value: 'PUT' },
        { label: 'DELETE', value: 'DELETE' },
        { label: 'HEAD', value: 'HEAD' },
        { label: 'PATCH', value: 'PATCH' },
        { label: 'OPTIONS', value: 'OPTIONS' },
      ],
      statusOptions: [
        { label: '未完成', value: 1 },
        { label: '已完成', value: 2 },
      ],
      roleOptions: [
        { label: '组长', value: 'leader' },
        { label: '研发', value: 'dever' },
      ],
      requiredOptions: [
        { label: '必填', value: 1 },
        { label: '选填', value: 2 },
      ],
      dataTypeOptions: [
        { label: 'Object', value: 'Object' },
        { label: 'Array', value: 'Array' },
        { label: 'String', value: 'String' },
        { label: 'Number', value: 'Number' },
        { label: 'Integer', value: 'Integer' },
        { label: 'Float', value: 'Float' },
        { label: 'Double', value: 'Double' },
        { label: 'Date', value: 'Date' },
        { label: 'DateTime', value: 'DateTime' },
        { label: 'TimeStamp', value: 'TimeStamp' },
        { label: 'Boolean', value: 'Boolean' },
      ],
    };
  },
};
