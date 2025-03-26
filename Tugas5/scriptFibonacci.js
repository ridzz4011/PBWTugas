const calculateFibonacci = n => {
    const sequence = [];
    if (n >= 1) sequence.push(0);
    if (n >= 2) sequence.push(1);
    for (let i = 2; i < n; i++) {
      sequence.push(sequence[i - 1] + sequence[i - 2]);
    }
    return sequence;
  };

  const handleSubmit = event => {
    event.preventDefault();
    const inputValue = document.getElementById('fibInput').value;
    const n = parseInt(inputValue);
    if (isNaN(n) || n <= 0) {
      alert("Please enter a positive integer");
      return;
    }
    const result = calculateFibonacci(n);
    document.getElementById('output').textContent = result.join(', ');
  };