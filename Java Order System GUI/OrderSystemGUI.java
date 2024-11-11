import javax.swing.*;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.DefaultTableModel;
import javax.swing.table.TableCellEditor;
import javax.swing.table.TableCellRenderer;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.geom.Ellipse2D;
import java.awt.image.BufferedImage;
import javax.imageio.ImageIO;
import java.io.File;
import java.io.IOException;

public class OrderSystemGUI extends JFrame {
    private JTextField nameField;
    private JTextField quantityField;
    private JTable table;
    private DefaultTableModel model;
    private JTextField totalField;

    public OrderSystemGUI() {
        initComponents();
    }

    private void initComponents() {
        setTitle("Marlie's Brew Haven");
        setDefaultCloseOperation(WindowConstants.EXIT_ON_CLOSE);
        setSize(600, 500);
        setLayout(new GridBagLayout());
        setBackground(new Color(238, 228, 204));
        JLabel backgroundLabel = new JLabel();
        backgroundLabel.setIcon(new ImageIcon("bg.png"));
        setContentPane(backgroundLabel);
        setLayout(new GridBagLayout());

        GridBagConstraints constraints = new GridBagConstraints();
        constraints.anchor = GridBagConstraints.WEST;
        constraints.insets = new Insets(5, 5, 5, 5);

        try {
            BufferedImage logoImage = ImageIO.read(new File("logo1.png"));
            Image scaledLogoImage = logoImage.getScaledInstance(80, 80, Image.SCALE_SMOOTH);
            BufferedImage roundedLogoImage = new BufferedImage(80, 80, BufferedImage.TYPE_INT_ARGB);
            Graphics2D g2d = roundedLogoImage.createGraphics();
            g2d.setClip(new Ellipse2D.Float(0, 0, 80, 80));
            g2d.drawImage(scaledLogoImage, 0, 0, null);
            g2d.dispose();
            ImageIcon logoIcon = new ImageIcon(roundedLogoImage);
            JLabel logoLabel = new JLabel(logoIcon);
            constraints.gridx = 4;
            constraints.gridy = 0;
            add(logoLabel, constraints);
        } catch (IOException ex) {
            ex.printStackTrace();
        }

        JLabel nameLabel = new JLabel("Name:");
        constraints.gridx = 1;
        constraints.gridy = 0;
        add(nameLabel, constraints);

        nameField = new JTextField(15);
        constraints.gridx = 2;
        constraints.gridy = 0;
        constraints.insets = new Insets(5, 5, 5, 25);
        nameField.setBackground(Color.WHITE);
        add(nameField, constraints);

        JLabel orderLabel = new JLabel("Order:");
        constraints.gridx = 1;
        constraints.gridy = 1;
        constraints.insets = new Insets(5, 5, 5, 5);
        add(orderLabel, constraints);

        String[] orders = {"Iced coffee", "Frappe", "Espresso", "Latte", "Cappuccino", "Mocha", "Americano"};
        JComboBox<String> orderBox = new JComboBox<>(orders);
        orderBox.setPreferredSize(nameField.getPreferredSize());
        constraints.gridx = 2;
        constraints.gridy = 1;
        orderBox.setBackground(Color.WHITE);
        add(orderBox, constraints);

        JLabel orderSizeLabel = new JLabel("Order Size:");
        constraints.gridx = 1;
        constraints.gridy = 2;
        add(orderSizeLabel, constraints);

        ButtonGroup orderSizeGroup = new ButtonGroup();
        JRadioButton smallButton = new JRadioButton("Small");
        JRadioButton mediumButton = new JRadioButton("Medium");
        JRadioButton largeButton = new JRadioButton("Large");
        orderSizeGroup.add(smallButton);
        orderSizeGroup.add(mediumButton);
        orderSizeGroup.add(largeButton);
        JPanel sizePanel = new JPanel(new FlowLayout(FlowLayout.LEFT, 0, 0));
        sizePanel.setBackground(Color.WHITE);
        smallButton.setBackground(sizePanel.getBackground());
        mediumButton.setBackground(sizePanel.getBackground());
        largeButton.setBackground(sizePanel.getBackground());
        sizePanel.add(smallButton);
        sizePanel.add(mediumButton);
        sizePanel.add(largeButton);
        constraints.gridx = 2;
        constraints.gridy = 2;
        constraints.anchor = GridBagConstraints.WEST;
        constraints.ipadx = 0;
        add(sizePanel, constraints);

        ButtonGroup orderTypeGroup = new ButtonGroup();
        JRadioButton type1Button = new JRadioButton("Hot");
        JRadioButton type2Button = new JRadioButton("Cold");
        orderTypeGroup.add(type1Button);
        orderTypeGroup.add(type2Button);
        JPanel radioPanel = new JPanel(new FlowLayout(FlowLayout.LEFT, 0, 0));
        radioPanel.setBackground(Color.WHITE);
        type1Button.setBackground(radioPanel.getBackground());
        type2Button.setBackground(radioPanel.getBackground());
        radioPanel.add(type1Button);
        radioPanel.add(type2Button);
        constraints = new GridBagConstraints();
        constraints.anchor = GridBagConstraints.WEST;
        constraints.insets = new Insets(5, 5, 5, 5);
        constraints.gridx = 2;
        constraints.gridy = 3;
        add(radioPanel, constraints);

        JLabel orderTypeLabel = new JLabel("Order Type:");
        constraints.gridx = 1;
        constraints.gridy = 3;
        add(orderTypeLabel, constraints);

        JLabel quantityLabel = new JLabel("Qty:");
        constraints.gridx = 3;
        constraints.gridy = 1;
        add(quantityLabel, constraints);

        quantityField = new JTextField(5);
        constraints.gridx = 4;
        constraints.gridy = 1;
        quantityField.setBackground(Color.WHITE);
        add(quantityField, constraints);

        String[] columns = {"Order (Name, Size, Type)", "Quantity", "Amount", "Edit", "Delete"};
        model = new DefaultTableModel(columns, 0) {
            @Override
            public boolean isCellEditable(int row, int column) {
                return column == 3 || column == 4; // Make "Edit" and "Delete" columns editable
            }
        };
        table = new JTable(model);
        table.getColumnModel().getColumn(3).setCellRenderer(new ButtonRenderer());
        table.getColumnModel().getColumn(3).setCellEditor(new ButtonEditor(new JCheckBox()));
        table.getColumnModel().getColumn(4).setCellRenderer(new ButtonRenderer());
        table.getColumnModel().getColumn(4).setCellEditor(new ButtonEditor(new JCheckBox()));
        table.getTableHeader().setFont(table.getTableHeader().getFont().deriveFont(Font.BOLD, 15));
        table.getTableHeader().setForeground(Color.WHITE);
        table.getTableHeader().setBackground(new Color(108, 52, 40));
        table.setBackground(Color.LIGHT_GRAY);
        JScrollPane scrollPane = new JScrollPane(table);
        scrollPane.setPreferredSize(new Dimension(400, 150));
        constraints.gridx = 0;
        constraints.gridy = 4;
        constraints.gridwidth = 5;
        add(scrollPane, constraints);
        DefaultTableCellRenderer centerRenderer = new DefaultTableCellRenderer();
        centerRenderer.setHorizontalAlignment(JLabel.CENTER);
        table.setDefaultRenderer(Object.class, centerRenderer);

        JLabel totalAmountLabel = new JLabel("                   TOTAL:");
        totalAmountLabel.setFont(totalAmountLabel.getFont().deriveFont(Font.BOLD, totalAmountLabel.getFont().getSize() + 9f));
        constraints.gridx = 2;
        constraints.gridy = 5;
        add(totalAmountLabel, constraints);

        totalField = new JTextField("0.00", 10);
        totalField.setEditable(false);
        totalField.setPreferredSize(new Dimension(totalField.getPreferredSize().width, totalField.getPreferredSize().height + 15));
        constraints.gridx = 3;
        constraints.gridy = 5;
        constraints.gridwidth = 2;
        add(totalField, constraints);

        JButton manualAddButton = new JButton("Add");
        manualAddButton.setFont(manualAddButton.getFont().deriveFont(Font.BOLD, 15));
        manualAddButton.setBackground(new Color(92, 64, 51));
        manualAddButton.setForeground(Color.WHITE);
        manualAddButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                // Your manual add button action here
                String name = nameField.getText();
                String order = null;
                String orderType = null;
                String orderSize = null;

                if (smallButton.isSelected()) {
                    orderSize = "Small";
                } else if (mediumButton.isSelected()) {
                    orderSize = "Medium";
                } else if (largeButton.isSelected()) {
                    orderSize = "Large";
                }

                if (type1Button.isSelected()) {
                    orderType = "Hot";
                } else if (type2Button.isSelected()) {
                    orderType = "Cold";
                }
                if (orderBox.getSelectedIndex() != -1) {
                    order = orders[orderBox.getSelectedIndex()];
                }

                String quantity = quantityField.getText();

                if (!name.isEmpty() && order != null && orderSize != null && orderType != null && !quantity.isEmpty()) {
                    double totalAmount = Double.parseDouble(quantity) * calculateAmount(order, orderSize);
                    model.addRow(new Object[]{order + " " + " (" + name + "," + orderSize + ", " + orderType + ")", quantity, String.format("%.2f", totalAmount), "Edit", "Delete"});
                    updateTotalAmount();

                    nameField.setText("");
                    quantityField.setText("");
                    orderBox.setSelectedIndex(-1);
                    orderSizeGroup.clearSelection();
                    orderTypeGroup.clearSelection();
                } else {
                    JOptionPane.showMessageDialog(OrderSystemGUI.this, "Name, order, order size, order type, and quantity cannot be empty.");
                }
            }
        });
        constraints.gridx = 1;
        constraints.gridy = 6;
        add(manualAddButton, constraints);

        JButton clearButton = new JButton("Clear");
        clearButton.setFont(clearButton.getFont().deriveFont(Font.BOLD, 15));
        clearButton.setBackground(new Color(92, 64, 51));
        clearButton.setForeground(Color.WHITE);
        clearButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                model.setRowCount(0);
                updateTotalAmount();
            }
        });
        constraints.gridx = 2;
        constraints.gridy = 6;
        add(clearButton, constraints);

        JButton checkoutButton = new JButton("Checkout");
        checkoutButton.setFont(checkoutButton.getFont().deriveFont(Font.BOLD, 15));
        checkoutButton.setBackground(new Color(92, 64, 51));
        checkoutButton.setForeground(Color.WHITE);
        checkoutButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                // Checkout button action here
                int confirm = JOptionPane.showConfirmDialog(OrderSystemGUI.this, "Are you sure you want to proceed to checkout?", "Confirm Checkout", JOptionPane.YES_NO_OPTION);
                if (confirm == JOptionPane.YES_OPTION) {
                    // Build order summary
                    StringBuilder orderSummary = new StringBuilder();
                    double totalAmount = 0.0;
                    for (int i = 0; i < model.getRowCount(); i++) {
                        orderSummary.append("Order details: ").append(model.getValueAt(i, 0)).append("\n");
                        orderSummary.append("Quantity: ").append(model.getValueAt(i, 1)).append("\n");
                        orderSummary.append("Subtotal: PHP ").append(model.getValueAt(i, 2)).append("\n");
                        orderSummary.append("Delivery: PHP 25.00").append("\n\n");
                        totalAmount += Double.parseDouble((String) model.getValueAt(i, 2));
                    }

                    // Adding delivery fee to the total amount
                    double deliveryFee = 25.0;
                 // Open OrderSummary window
                    double total = 0;
                    for (int i = 0; i < model.getRowCount(); i++) {
                        total += Double.parseDouble((String) model.getValueAt(i, 2));
                    }
                    total += deliveryFee;
                    OrderSummary summaryFrame = new OrderSummary(orderSummary.toString(), total, total);
                    summaryFrame.setVisible(true);
                    
                    

                    JLabel deliveryFeeLabel = new JLabel("Delivery Fee: PHP " + String.format("%.2f", deliveryFee));
                    // Update the total field with the new total amount
                    totalField.setText(String.format("%.2f", totalAmount));

                    JPanel feePanel = new JPanel(new GridLayout(2, 1));
                    feePanel.add(deliveryFeeLabel);
                    feePanel.add(totalAmountLabel);

                    double amount;
					// Open OrderSummary window
                    OrderSummary summaryFrame1 = new OrderSummary(orderSummary.toString(), total, total);
                    summaryFrame1.setVisible(true);

                    // Clear the table and reset total amount
                    model.setRowCount(0);
                    updateTotalAmount();
                }
            }
        });
        GridBagConstraints constraints1 = new GridBagConstraints();
        constraints1.gridx = 3;
        constraints1.gridy = 6;
        add(checkoutButton, constraints1);
    }

    // Method to update the total amount
    private void updateTotalAmount() {
        double totalAmount = 0.0;
        for (int i = 0; i < model.getRowCount(); i++) {
            String quantityString = (String) model.getValueAt(i, 1);
            double quantity = Double.parseDouble(quantityString);
            String order = ((String) model.getValueAt(i, 0)).split("\\(")[0].trim();
            String size = ((String) model.getValueAt(i, 0)).split("\\(")[1].split(",")[1].trim();
            double amount = calculateAmount(order, size);
            totalAmount += quantity * amount;
        }
        totalField.setText(String.format("%.2f", totalAmount));
    }

    // Method to calculate the amount based on the order and size
    private double calculateAmount(String order, String size) {
        double amount = 0.0;

        switch (order) {
            case "Iced coffee":
                switch (size) {
                    case "Small":
                        amount = 25.0;
                        break;
                    case "Medium":
                        amount = 50.0;
                        break;
                    case "Large":
                        amount = 75.0;
                        break;
                }
                break;
            case "Frappe":
                switch (size) {
                    case "Small":
                        amount = 60.0;
                        break;
                    case "Medium":
                        amount = 70.0;
                        break;
                    case "Large":
                        amount = 80.0;
                        break;
                }
                break;
            case "Espresso":
                switch (size) {
                    case "Small":
                        amount = 70.0;
                        break;
                    case "Medium":
                        amount = 85.0;
                        break;
                    case "Large":
                        amount = 100.0;
                        break;
                }
                break;
            case "Latte":
                switch (size) {
                    case "Small":
                        amount = 100.0;
                        break;
                    case "Medium":
                        amount = 120.0;
                        break;
                    case "Large":
                        amount = 140.0;
                        break;
                }
                break;
            case "Cappuccino":
                switch (size) {
                    case "Small":
                        amount = 90.0;
                        break;
                    case "Medium":
                        amount = 125.0;
                        break;
                    case "Large":
                        amount = 130.0;
                        break;
                }
                break;
            case "Mocha":
                switch (size) {
                    case "Small":
                        amount = 100.0;
                        break;
                    case "Medium":
                        amount = 120.0;
                        break;
                    case "Large":
                        amount = 135.0;
                        break;
                }
                break;
            case "Americano":
                switch (size) {
                    case "Small":
                        amount = 85.0;
                        break;
                    case "Medium":
                        amount = 100.0;
                        break;
                    case "Large":
                        amount = 115.0;
                        break;
                }
                break;
        }

        return amount;
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(new Runnable() {
            @Override
            public void run() {
                OrderSystemGUI frame = new OrderSystemGUI();
                frame.setVisible(true);
            }
        });
    }

    class ButtonRenderer extends JButton implements TableCellRenderer {
        public ButtonRenderer() {
            setOpaque(true);
        }

        @Override
        public Component getTableCellRendererComponent(JTable table, Object value, boolean isSelected, boolean hasFocus, int row, int column) {
            setBackground(Color.WHITE);
            setText(value == null ? "" : value.toString());
            return this;
        }
    }

    class ButtonEditor extends DefaultCellEditor {
        protected JButton button;
        private String label;
        private boolean isPushed;

        public ButtonEditor(JCheckBox checkBox) {
            super(checkBox);
            button = new JButton();
            button.setOpaque(true);
            button.addActionListener(new ActionListener() {
                @Override
                public void actionPerformed(ActionEvent e) {
                    fireEditingStopped();
                }
            });
        }

        @Override
        public Component getTableCellEditorComponent(JTable table, Object value, boolean isSelected, int row, int column) {
            if (isSelected) {
                button.setForeground(table.getSelectionForeground());
                button.setBackground(table.getSelectionBackground());
            } else {
                button.setForeground(table.getForeground());
                button.setBackground(UIManager.getColor("Button.background"));
            }
            label = (value == null) ? "" : value.toString();
            button.setText(label);
            isPushed = true;
            return button;
        }

        @Override
        public Object getCellEditorValue() {
            if (isPushed) {
                // Perform the corresponding action based on the button clicked
                if (label.equals("Edit")) {
                    String newValue = JOptionPane.showInputDialog(button, "Enter new quantity:", "");
                    if (newValue != null) {
                        try {
                            int newQuantity = Integer.parseInt(newValue);
                            if (newQuantity >= 0) {
                                table.getModel().setValueAt(newValue, table.convertRowIndexToModel(table.getEditingRow()), 1);
                                updateTotalAmount();
                            } else {
                                JOptionPane.showMessageDialog(button, "Quantity must be a positive integer.");
                            }
                        } catch (NumberFormatException ex) {
                            JOptionPane.showMessageDialog(button, "Invalid input. Please enter a valid integer.");
                        }
                    }
                } else if (label.equals("Delete")) {
                    int confirm = JOptionPane.showConfirmDialog(button, "Are you sure you want to delete this item?", "Confirm Deletion", JOptionPane.YES_NO_OPTION);
                    if (confirm == JOptionPane.YES_OPTION) {
                        int modelRow = table.convertRowIndexToModel(table.getEditingRow());
                        ((DefaultTableModel) table.getModel()).removeRow(modelRow);
                        updateTotalAmount();
                    }
                }
            }
            isPushed = false;
            return label;
        }

        @Override
        public boolean stopCellEditing() {
            isPushed = false;
            return super.stopCellEditing();
        }
    }
}
