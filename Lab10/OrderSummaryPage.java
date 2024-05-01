import javax.imageio.ImageIO;
import javax.swing.*;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.DefaultTableModel;
import javax.swing.table.TableCellRenderer;
import javax.swing.table.TableColumn;

import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.geom.Ellipse2D;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.IOException;

public class OrderSummaryPage extends JFrame {
    private JLabel nameLabel;
    private JLabel addressLabel;
    private JLabel contactLabel;
    private JLabel remarksLabel;
    private JTable orderTable;
    private JTextArea textArea;

    public OrderSummaryPage(String name, String address, String contact, String remarks, Object[][] orderData) {
        initComponents(name, address, contact, remarks, orderData);
    }

    private void initComponents(String name, String address, String contact, String remarks, Object[][] orderData) {
        setTitle("Order Summary");
        setDefaultCloseOperation(WindowConstants.DISPOSE_ON_CLOSE);
        setSize(780, 480);
        Color brownColor = new Color(228, 197, 158); // Cream color RGB values
        getContentPane().setBackground(brownColor);
        getContentPane().setBackground(Color.WHITE);
        setLayout(new GridBagLayout());

        GridBagConstraints constraints = new GridBagConstraints();
        constraints.anchor = GridBagConstraints.WEST;
        constraints.insets = new Insets(5, 5, 5, 5);

        nameLabel = new JLabel("Customer's Name: " + name);
        constraints.gridx = 0;
        constraints.gridy = 0;
        constraints.gridwidth = 2;
        add(nameLabel, constraints);

        addressLabel = new JLabel("Address: " + address);
        constraints.gridy = 1;
        add(addressLabel, constraints);

        contactLabel = new JLabel("Contact No.: " + contact);
        constraints.gridy = 2;
        add(contactLabel, constraints);

        remarksLabel = new JLabel("Remarks: " + remarks);
        constraints.gridy = 3;
        add(remarksLabel, constraints);

        try {
            BufferedImage logoImage = ImageIO.read(new File("logo1.png"));
            Image scaledLogoImage = logoImage.getScaledInstance(100, 100, Image.SCALE_SMOOTH);
            BufferedImage roundedLogoImage = new BufferedImage(100, 100, BufferedImage.TYPE_INT_ARGB);
            Graphics2D g2d = roundedLogoImage.createGraphics();
            g2d.setClip(new Ellipse2D.Float(0, 0, 100, 100));
            g2d.drawImage(scaledLogoImage, 0, 0, null);
            g2d.dispose();
            ImageIcon logoIcon = new ImageIcon(roundedLogoImage);
            JLabel logoLabel = new JLabel(logoIcon);
            constraints.gridx = 2;
            constraints.gridy = 0;
            add(logoLabel, constraints);
        } catch (IOException ex) {
            ex.printStackTrace();
        }

        // Create table to display order details
        String[] columnNames = {"Order List", "Quantity", "Amount", "Edit", "Delete"};
        DefaultTableModel model = new DefaultTableModel(orderData, columnNames) {
            @Override
            public boolean isCellEditable(int row, int column) {
                // Make only the Quantity column editable
                return column == 3 || column == 4;
            }
        };
        orderTable = new JTable(model);
        orderTable.getColumnModel().getColumn(3).setCellRenderer(new ButtonRenderer("Edit"));
        orderTable.getColumnModel().getColumn(3).setCellEditor(new ButtonEditor(new JCheckBox(), "Edit"));
        orderTable.getColumnModel().getColumn(4).setCellRenderer(new ButtonRenderer("Delete"));
        orderTable.getColumnModel().getColumn(4).setCellEditor(new ButtonEditor(new JCheckBox(), "Delete"));
        orderTable.getTableHeader().setFont(orderTable.getTableHeader().getFont().deriveFont(Font.BOLD, 15));
        orderTable.getTableHeader().setForeground(Color.WHITE);
        orderTable.getTableHeader().setBackground(new Color(108, 52, 40));

        // Add table to scroll pane
        JScrollPane scrollPane = new JScrollPane(orderTable);
        scrollPane.setPreferredSize(new Dimension(400, 124));
        constraints.gridx = 0;
        constraints.gridy = 4;
        constraints.gridwidth = 2;
        add(scrollPane, constraints);
        DefaultTableCellRenderer centerRenderer = new DefaultTableCellRenderer();
        centerRenderer.setHorizontalAlignment(JLabel.CENTER);
        orderTable.setDefaultRenderer(Object.class, centerRenderer);

        // Initialize text area
        textArea = new JTextArea();
        textArea.setEditable(false); // Ensure text area is not editable
        JScrollPane textAreaScrollPane = new JScrollPane(textArea);
        textAreaScrollPane.setPreferredSize(new Dimension(400, 100));
        constraints.gridx = 0;
        constraints.gridy = 5;
        constraints.gridwidth = 2;
        add(textAreaScrollPane, constraints);

        // Add buttons
        JButton addButton = new JButton("Add");
        addButton.setPreferredSize(new Dimension(96, 35));
        addButton.setFont(addButton.getFont().deriveFont(Font.BOLD, 15));
        addButton.setBackground(new Color(92, 64, 51));
        addButton.setForeground(Color.WHITE);
        addButton.addActionListener(e -> {
            addInformationToTextArea();
        });

        JButton clearButton = new JButton("Clear");
        clearButton.setFont(clearButton.getFont().deriveFont(Font.BOLD, 15));
        clearButton.setBackground(new Color(92, 64, 51));
        clearButton.setForeground(Color.WHITE);
        clearButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                model.setRowCount(0);
            }
        });
        constraints.gridx = 2;
        constraints.gridy = 6;
        add(clearButton, constraints);

        JButton checkoutButton = new JButton("Checkout");
        checkoutButton.setPreferredSize(new Dimension(120, 35));
        checkoutButton.setFont(checkoutButton.getFont().deriveFont(Font.BOLD, 15));
        checkoutButton.setBackground(new Color(92, 64, 51));
        checkoutButton.setForeground(Color.WHITE);
        checkoutButton.addActionListener(e -> {
        	int confirm = JOptionPane.showConfirmDialog(OrderSummaryPage.this, "Are you sure you want to proceed to checkout?", "Confirm Checkout", JOptionPane.YES_NO_OPTION);
            new CheckoutPage(name, orderData, orderData).setVisible(true);
            setVisible(false);
            dispose();
        });

        constraints.gridy = 5;
        constraints.gridx = 2;
        add(addButton, constraints);

        constraints.gridx = 4;
        add(clearButton, constraints);

        constraints.gridx = 7;
        add(checkoutButton, constraints);

        setVisible(true);
    }

    private void addInformationToTextArea() {
        DefaultTableModel model = (DefaultTableModel) orderTable.getModel();
        int rowCount = model.getRowCount();

        StringBuilder information = new StringBuilder();
        for (int i = 0; i < rowCount; i++) {
            String orderList = model.getValueAt(i, 0).toString();
            String quantity = model.getValueAt(i, 1).toString();
            String amount = model.getValueAt(i, 2).toString();
            information.append("Order List: ").append(orderList).append(", Quantity: ").append(quantity).append(", Amount: ").append(amount).append("\n");
        }

        textArea.setText(information.toString());
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(() -> {
            String name = "No name";
            String address = "Philippines";
            String contact = "09XX-XXX-XXX";
            String remarks = "No remarks";

            Object[][] sampleOrderData = {
                    {"Iced Coffee, Cold, Medium", "2", "50.00"},
                    {"Latte, Hot, Medium", "1", "100.00"}
            };

            OrderSummaryPage orderSummaryPage = new OrderSummaryPage(name, address, contact, remarks, sampleOrderData);
            orderSummaryPage.setVisible(true);
        });
    }
    
    class ButtonRenderer extends JButton implements TableCellRenderer {
        private String buttonText;

        public ButtonRenderer(String text) {
            setOpaque(true);
            buttonText = text;
        }

        @Override
        public Component getTableCellRendererComponent(JTable table, Object value, boolean isSelected, boolean hasFocus, int row, int column) {
            setBackground(Color.WHITE);
            setText(buttonText);
            return this;
        }
    }

    class ButtonEditor extends DefaultCellEditor {
        protected JButton button;
        private String label;
        private boolean isPushed;

        public ButtonEditor(JCheckBox checkBox, String text) {
            super(checkBox);
            button = new JButton();
            button.setOpaque(true);
            button.addActionListener(new ActionListener() {
                @Override
                public void actionPerformed(ActionEvent e) {
                    fireEditingStopped();
                    getCellEditorValue(); // Perform action when button is clicked
                }
            });
            label = text;
            button.setText(label);
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
                                orderTable.getModel().setValueAt(newValue, orderTable.convertRowIndexToModel(orderTable.getEditingRow()), 1);
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
                        int modelRow = orderTable.convertRowIndexToModel(orderTable.getEditingRow());
                        ((DefaultTableModel) orderTable.getModel()).removeRow(modelRow);
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
