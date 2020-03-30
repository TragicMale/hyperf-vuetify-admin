function findAllParentById(nodeId, tree) {
  if (!nodeId) {
    return;
  }
  let node = findNode(nodeId, tree);

  let parentNodes = findAllParent(node, tree);

  let pids = [];
  if (parentNodes && parentNodes.length > 0) {
    parentNodes.map(node => {
      pids.push(node.id);
    });
  }
  return pids.reverse();
}

function findAllParent(node, tree, parentNodes = [], index = 0) {
  if (!node || node.pid === 0) {
    return;
  }
  findParent(node, parentNodes, tree);
  let parntNode = parentNodes[index];
  findAllParent(parntNode, tree, parentNodes, ++index);
  return parentNodes;
}

function findParent(node, parentNodes, tree) {
  for (let i = 0; i < tree.length; i++) {
    let item = tree[i];
    if (item.id === node.pid) {
      parentNodes.push(item);
      return;
    }
    if (item.children && item.children.length > 0) {
      findParent(node, parentNodes, item.children);
    }
  }
}

function findNode(nodeId, tree) {
  for (let i = 0; i < tree.length; i++) {
    let item = tree[i];
    if (item.id === nodeId) {
      return item;
    }
    if (item.children && item.children.length > 0) {
      let find = findNode(nodeId, item.children);
      if (find) {
        return find;
      }
    }
  }
}
export default findAllParentById;
