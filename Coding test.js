function findTargetIndex(nums, target) {
  nums.sort((a, b) => a - b);

  let left = 0;
  let right = nums.length - 1;

  while (left <= right) {
    let mid = Math.floor((left + right) / 2);
    if (nums[mid] === target) {
      return mid;
    } else if (nums[mid] < target) {
      left = mid + 1;
    } else {
      right = mid - 1;
    }
  }

  return left;
}

function processUserInput() {

  let numsInput = prompt("Enter numbers separated by commas (e.g., 1,2,3):");
  let nums = numsInput.split(',').map(num => parseInt(num.trim(), 10));

  let targetInput = prompt("Enter target number:");
  let target = parseInt(targetInput.trim(), 10);

  let index = findTargetIndex(nums, target);

  alert(`Output: ${index}`);
}

processUserInput();