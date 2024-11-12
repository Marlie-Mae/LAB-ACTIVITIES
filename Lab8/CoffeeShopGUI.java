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
import javax.swing.table.TableColumnModel;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;
import javax.swing.table.AbstractTableModel;

public class CoffeeShopGUI extends JFrame {
    private JTextField nameField;
    private JTextField quantityField;
    private JTable table;
    private DefaultTableModel model;
    private JTextField totalField;

    public CoffeeShopGUI() {
        initComponents();
    }

    private void initComponents() {
        setTitle("Marlie's Brew Haven");
        setDefaultCloseOperation(WindowConstants.EXIT_ON_CLOSE);
        setSize(600, 500);
        setLayout(new GridBagLayout());
        setBackground(new Color(238,228,204));
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
           g2d.setClip(new Ellipse2D.Float(0, 0, 80, 80)); // Clip the image to a circle
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
                return false;
            }
        };
        table = new JTable(model);
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
        manualAddButton.setFont(manualAddButton.getFont().deriveFont(Font.BOLD,15));
        manualAddButton.setBackground(new Color(92, 64, 51)); 
        manualAddButton.setForeground(Color.WHITE);
        manualAddButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
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
                    double amount = 0.0;
                    switch (orderBox.getSelectedIndex()) {
                    case 0: // Iced coffee
                        amount = 40.0;
                        break;
                    case 1: // Frappe
                        amount = 60.0;
                        break;
                    case 2: // Espresso
                        amount = 70.0;
                        break;
                    case 3: // Latte
                        amount = 100.0;
                        break;
                    case 4: // Cappuccino
                        amount = 90.0;
                        break;
                    case 5: // Mocha
                        amount = 100.0;
                        break;
                    case 6: // Americano
                        amount = 85.0;
                        break;
                    }

                    double totalAmount = Double.parseDouble(quantity) * amount;
                    model.addRow(new Object[]{order + " " + " (" + name + "," + orderSize + ", " + orderType + ")", quantity, String.format("%.2f", totalAmount), "Edit", "Delete"});
                    updateTotalAmount();

                    nameField.setText("");
                    quantityField.setText("");
                    orderBox.setSelectedIndex(-1);
                    orderSizeGroup.clearSelection();
                    orderTypeGroup.clearSelection();
                } else {
                    JOptionPane.showMessageDialog(CoffeeShopGUI.this, "Name, order, order size, order type, and quantity cannot be empty.");
                }
            }
        });
        constraints.gridx = 1;
        constraints.gridy = 6;
        add(manualAddButton, constraints);

        JButton clearButton = new JButton("Clear");
        clearButton.setFont(clearButton.getFont().deriveFont(Font.BOLD,15));
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
        checkoutButton.setFont(clearButton.getFont().deriveFont(Font.BOLD,15));
        checkoutButton.setBackground(new Color(92, 64, 51)); 
        checkoutButton.setForeground(Color.WHITE);
        checkoutButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {

                double subtotal = Double.parseDouble(totalField.getText());
                double deliveryFee = 100.0;
                double total = subtotal + deliveryFee;

                String customerName = nameField.getText();
                if (customerName.isEmpty() && model.getRowCount() > 0) {
                    String[] orderDetails = ((String) model.getValueAt(0, 0)).split(" ");
                    customerName = orderDetails[orderDetails.length - 1];
                }


                BufferedImage logoImage = null;
                try {
                    logoImage = ImageIO.read(new File("logo1.png"));
                } catch (IOException ex) {
                    ex.printStackTrace();
                }
                Image scaledLogoImage = logoImage.getScaledInstance(80, 80, Image.SCALE_SMOOTH);
                BufferedImage roundedLogoImage = new BufferedImage(80, 80, BufferedImage.TYPE_INT_ARGB);
                Graphics2D g2d = roundedLogoImage.createGraphics();
                g2d.setClip(new Ellipse2D.Float(0, 0, 80, 80)); 
                g2d.drawImage(scaledLogoImage, 0, 0, null);
                g2d.dispose();
                ImageIcon logoIcon = new ImageIcon(roundedLogoImage);

                StringBuilder orderSummaryBuilder = new StringBuilder();
                orderSummaryBuilder.append("<html><body>");
                orderSummaryBuilder.append("<b>SUMMARY</b><br><img src='file:logo1.png' align='left' width='50' height='50'><br>");
                orderSummaryBuilder.append("Customer Name: <font size='+1'>").append(customerName).append("</font><br>");
                orderSummaryBuilder.append("Order Details:<br>");
               for (int i = 0; i < model.getRowCount(); i++) {
                orderSummaryBuilder.append(model.getValueAt(i, 0)).append(", Quantity: ").append(model.getValueAt(i, 1)).append("<br>");}
                orderSummaryBuilder.append("<br>");
                orderSummaryBuilder.append("Subtotal: PHP ").append(String.format("%.2f", subtotal)).append("<br>");
                orderSummaryBuilder.append("Delivery Fee: PHP ").append(String.format("%.2f", deliveryFee)).append("<br>");
                orderSummaryBuilder.append("<br>");
                orderSummaryBuilder.append("Total: PHP ").append(String.format("%.2f", total)).append("<br>");
                orderSummaryBuilder.append("</body></html>");


                JOptionPane.showMessageDialog(CoffeeShopGUI.this, orderSummaryBuilder.toString());

            }
        });
        constraints.gridx = 4;
        constraints.gridy = 6;
        add(checkoutButton, constraints);

        // Create a button column for each row
        ButtonColumn editButtonColumn = new ButtonColumn(table, new AbstractAction() {
            @Override
            public void actionPerformed(ActionEvent e) {
                // Get the row and perform edit operation
                int modelRow = Integer.valueOf(e.getActionCommand());
                editRow(modelRow);
            }
        }, table.getColumnCount() - 2); // Edit button column index

        ButtonColumn deleteButtonColumn = new ButtonColumn(table, new AbstractAction() {
            @Override
            public void actionPerformed(ActionEvent e) {
                // Get the row and perform delete operation
                int modelRow = Integer.valueOf(e.getActionCommand());
                deleteRow(modelRow);
            }
        }, table.getColumnCount() - 1); // Delete button column index

        setLocationRelativeTo(null);
    }

    private void updateTotalAmount() {
        double totalAmount = 0.0;
        for (int row = 0; row < model.getRowCount(); row++) {
            String amountStr = (String) model.getValueAt(row, 2);
            totalAmount += Double.parseDouble(amountStr);
        }
        totalField.setText(String.format("%.2f", totalAmount));
    }

    private void editRow(int row) {
        String newQuantity = JOptionPane.showInputDialog(CoffeeShopGUI.this, "Enter new quantity:");
        if (newQuantity != null && !newQuantity.isEmpty()) {
            model.setValueAt(newQuantity, row, 1);
            updateTotalAmount();
        }
    }

    private void deleteRow(int row) {
        model.removeRow(row);
        updateTotalAmount();
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(new Runnable() {
            @Override
            public void run() {
                CoffeeShopGUI frame = new CoffeeShopGUI();
                frame.setVisible(true);
            }
        });
    }

    class ButtonColumn extends AbstractCellEditor implements TableCellRenderer, TableCellEditor, ActionListener {
        JTable table;
        Action action;
        int mnemonic;
        public ButtonColumn(JTable table, Action action, int column) {
            this.table = table;
            this.action = action;
            TableColumnModel columnModel = table.getColumnModel();
            columnModel.getColumn(column).setCellRenderer(this);
            columnModel.getColumn(column).setCellEditor(this);
            table.addMouseListener(new MouseAdapter() {
                public void mousePressed(MouseEvent e) {
                    int column = table.getColumnModel().getColumnIndexAtX(e.getX());
                    int row = e.getY() / table.getRowHeight();
                    if (row < table.getRowCount() && row >= 0 && column < table.getColumnCount() && column >= 0) {
                        fireEditingStopped();
                        action.actionPerformed(new ActionEvent(table, ActionEvent.ACTION_PERFORMED, "" + row));
                    }
                }
            });
        }
        public Object getCellEditorValue() {
            return null;
        }
        public Component getTableCellRendererComponent(JTable table, Object value, boolean isSelected, boolean hasFocus, int row, int column) {
            JButton button = new JButton();
            button.addActionListener(this);
            button.setActionCommand(String.valueOf(row));
            button.setIcon(new ImageIcon("logo.png")); // Replace with your icon
            return button;
        }
        public Component getTableCellEditorComponent(JTable table, Object value, boolean isSelected, int row, int column) {
            return null;
        }
        public void actionPerformed(ActionEvent e) {
            int row = Integer.parseInt(e.getActionCommand());
            fireEditingStopped();
            action.actionPerformed(new ActionEvent(table, ActionEvent.ACTION_PERFORMED, "" + row));
        }
    }
}
