# Cyclomatic Complexity

Cyclomatic Complexity adalah metrik kuantitatif untuk mengukur kompleksitas logis dari suatu program.

## Fungsi: `AuthValidationService::validateLoginInput`

### Rumus Perhitungan
Rumus V(G) dapat dihitung dengan 3 cara:
1.  **V(G) = E - N + 2** (E = Edge, N = Node)
2.  **V(G) = P + 1** (P = Predicate/Decision Node)
3.  **V(G) = R** (R = Region pada graph)

### Perhitungan Berdasarkan Graph
Berdasarkan CFG pada `docs/cfg-analysis.md`:
- **Nodes (N)**: 9
- **Edges (E)**: 12
  - (1,2), (1,3), (2,5), (3,4), (3,5), (4,5), (5,6), (5,7), (6,9), (7,8), (7,9), (8,9)
- **Predicate Nodes (P)**: 4
  - Node 1, Node 3, Node 5, Node 7

### Hasil V(G)
1.  **V(G) = 12 - 9 + 2 = 5**
2.  **V(G) = 4 + 1 = 5**

### Interpretasi
Nilai Cyclomatic Complexity sebesar **5** menunjukkan bahwa fungsi ini memiliki tingkat kompleksitas yang **Rendah (Simple)**. Disarankan maksimal nilai complexity adalah 10 untuk menjaga kode tetap maintainable.

## Kesimpulan Complexity
| Fungsi | V(G) | Kategori |
|---|---|---|
| `validateLoginInput` | 5 | Simple |
| `validateTaskInput` | 4 | Simple |
| `calculateTaskPriority` | 5 | Simple |
